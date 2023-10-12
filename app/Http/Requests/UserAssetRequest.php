<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Repositories\UserAssetClassRepository;
use App\Repositories\AssetRepository;
use App\Repositories\UserAssetRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'rating' => ['required', 'integer'],
            'quantity' => ['required', 'integer']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ticker.required' => 'O ticker é obrigatório',
            'rating.required' => 'A nota é obrigatória',
            'quantity.required' => 'A quantidade é obrigatória'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 422));
    }

    public function validateMaxQuantity(): void
    {
        $count = $this->userAssetRepository->getAssetsCountByUser($this->user()->id);

        if ($count >= env('ASSET_MAX_QUANTITY')) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => trans('asset.max_quantity')
            ], 400));
        }
    }

    public function validateAsset(): object
    {
        $asset = $this->assetRepository->getAssetByTicker($this->ticker);

        if ($asset) {
            return $asset;
        }

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => trans('asset.not_found')
        ], 404));
    }

    public function validateAssetClass(int $assetClassId): object
    {
        $assetClass = $this->userAssetClassRepository->getByAssetClassId($this->user()->id, $assetClassId);

        if ($assetClass) {
            return $assetClass;
        }

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Cadastre a classe de ativos antes de adicionar o ativo.'
        ], 404));
    }
}
