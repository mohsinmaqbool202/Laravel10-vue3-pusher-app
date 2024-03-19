<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    /**
     * @param  Request $request
     * @return jsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'name' => 'required|string|max:250',
                'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
                'password' => 'required|string|min:6|confirmed'
            ]);

            if ($validate->fails()) {
                return $this->errorMessage(null, $validate->errors()->first(), 403);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return $this->successMessage($user, 'User registered successfully', 201);
        } catch (Exception $e) {
            return $this->errorMessage(null, $e->getMessage());
        }
    }

    /**
     * @param  Request $request
     * @return jsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required'
            ]);

            if ($validate->fails()) {
                return $this->errorMessage(null, $validate->errors()->first(), 403);
            }

            if (Auth::attempt($request->all())) {
                $data['token'] = $request->user()->createToken('token-name')->plainTextToken;
                $data['user'] = Auth::user();
                return $this->successMessage($data, 'User logged in successfully');
            }

            return $this->errorMessage(null, 'Invalid credentials', 401);
        } catch (Exception $e) {
            return $this->errorMessage(null, $e->getMessage());
        }
    }

    /**
     * @return jsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::user()->tokens()->delete();
            return $this->successMessage(null, 'User logged out successfully', 200);
        } catch (Exception $e) {
            return $this->errorMessage(null, $e->getMessage());
        }
    }
}
