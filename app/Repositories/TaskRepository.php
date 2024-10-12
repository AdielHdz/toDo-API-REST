<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{

    protected $task;
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function findAll()
    {
        return $this->task->all();
    }

    public function find($id)
    {
        return $this->task->find($id);
    }

    public function create(array $data)
    {
        return $this->task->create($data);
    }

    public function update($id, array $data)
    {
        $newData = [
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'expiration_date' => $data['expiration_date'],
            'created_at' => $data['created_at'],
        ];
        $user = $this->task->findOrFail($id);
        $user->update($newData);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->task->findOrFail($id);
        $user->delete();
    }

    public function findAllTasks($user_id)
    {
        return $this->task->where('user_id', $user_id)->get();
    }
}
