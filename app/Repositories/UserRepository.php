<?php

namespace App\Repositories;

use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

class UserRepository
{

    use HasApiTokens;
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findAll()
    {
        return $this->user->all();
    }

    public function find($id)
    {
        return $this->user->find($id);
    }

    public function create(array $data)
    {
        $newUser = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ];
        return $this->user->create($newUser);
    }

    public function update($id, array $data)
    {
        $user = $this->user->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
    }

    public function findByEmail(string $email)
    {
        return $this->user->where('email', $email)->first();
    }
}
