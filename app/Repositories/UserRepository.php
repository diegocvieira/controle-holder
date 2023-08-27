<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getData(int $userId): object
    {
        return $this->model->find($userId);
    }

    public function updateData(int $userId, array $data): void
    {
        $this->model->where('id', $userId)->update($data);
    }
}
