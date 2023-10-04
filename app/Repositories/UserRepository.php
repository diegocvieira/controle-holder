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

    public function getByEmail(string $email): ?object
    {
        return $this->model->where('email', $email)->first();
    }

    public function updateData(int $userId, array $data): void
    {
        $this->model->where('id', $userId)->update($data);
    }

    public function createUser(array $data): void
    {
        $this->model->create($data);
    }
}
