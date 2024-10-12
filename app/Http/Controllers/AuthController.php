<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Repositories\UserRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\error;

class AuthController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $email = $request->email;

        try {
            $user = $this->userRepository->findByEmail($email);

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }


    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string'
        ]);
        try {
            $newUser = $this->userRepository->create($request->all());

            $token = $newUser->createToken('auth_token')->plainTextToken;


            return response()->json([
                'user' => $newUser,
                'token' => $token
            ], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 400);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred: ' . $th->getMessage()], 500);
        }
    }
}
