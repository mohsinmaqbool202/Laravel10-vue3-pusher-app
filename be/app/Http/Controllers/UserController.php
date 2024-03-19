<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * @return jsonResponse
     */
    public function index() : jsonResponse
    {
        try {
            $users = User::where('id' , '<>', Auth::user()->id)->get();
            return $this->successMessage($users, 'Users list');
        } catch(\Exception $e) {
            return $this->errorMessage(null, $e->getMessage());
        }
    }
}
