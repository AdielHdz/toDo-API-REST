<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;

class UserController extends Controller
{

    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    public function index()
    {

        try {
            $users = $this->userRepository->findAll();

            return response()->json($users, 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }

    public function show(int $user_id)
    {

        try {
            $user = $this->userRepository->find($user_id);

            return response()->json($user, 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }
}
