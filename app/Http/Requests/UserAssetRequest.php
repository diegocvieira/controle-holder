<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Repositories\UserAssetClassRepository;
use App\Repositories\AssetRepository;
use App\Repositories\UserAssetRepository;
use Illuminate\Contracts\Validation\Validator;

class UserAssetRequest extends FormRequest
{
    protected $userAssetClassRepository;
    protected $assetRepository;
    protected $userAssetRepository;

    public function __construct(UserAssetClassRepository $userAssetClassRepository, AssetRepository $assetRepository, UserAssetRepository $userAssetRepository)
    {
        $this->userAssetClassRepository = $userAssetClassRepository;
        $this->assetRepository = $assetRepository;
        $this->userAssetRepository = $userAssetRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'ticker' => ['required', 'string'],
            'rating' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric']
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException;
     */
    public function failedValidation(Validator $validator): void
    {
        throw ValidationException::withMessages([
            'message' => $validator->errors()->first()
        ]);
    }

    public function validateMaxQuantity(): void
    {
        $count = $this->userAssetRepository->getAssetsCountByUser($this->user()->id);

        if ($count >= config('asset.max_quantity')) {
            throw ValidationException::withMessages([
                'message' => trans('asset.max_quantity')
            ]);
        }
    }

    public function validateAsset(): object
    {
        $asset = $this->assetRepository->getAssetByTicker($this->ticker);

        if ($asset) {
            return $asset;
        }

        throw ValidationException::withMessages([
            'message' => trans('asset.not_found')
        ]);
    }

    public function validateAssetClass(int $assetClassId): object
    {
        $assetClass = $this->userAssetClassRepository->getByAssetClassId($this->user()->id, $assetClassId);

        if ($assetClass) {
            return $assetClass;
        }

        throw ValidationException::withMessages([
            'message' => trans('asset.asset_class_not_found')
        ]);
    }
}
