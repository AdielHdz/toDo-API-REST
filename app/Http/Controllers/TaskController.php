<?php


namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        try {
            $tasks = $this->taskRepository->findAll();

            return response()->json($tasks, 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }

    public function show(int $id)
    {
        if (!$id) return response()->json(['message' => 'Parameter id is required'], 401);
        try {
            $task = $this->taskRepository->find($id);

            return response()->json($task, 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,in progress,completed',
            'expiration_date' => 'required|string',
            'created_at' => 'required|string',
        ]);
        try {
            $newTask = $this->taskRepository->create($request->all());

            return response()->json($newTask, 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,in progress,completed',
            'expiration_date' => 'required|string',
            'created_at' => 'required|string',
        ]);
        try {
            $updatedTask = $this->taskRepository->update($request->id, $request->all());

            return response()->json($updatedTask, 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }



    public function storeUserTasks(string $id)
    {
        if (!$id) return response()->json(['message' => 'Parameter id is required'], 401);
        try {
            $tasks = $this->taskRepository->findAllTasks($id);

            return response()->json($tasks, 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        if (!$id) return response()->json(['message' => 'Parameter id is required'], 401);
        try {
            $task = $this->taskRepository->delete($id);

            return response()->json($task, 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }
}
