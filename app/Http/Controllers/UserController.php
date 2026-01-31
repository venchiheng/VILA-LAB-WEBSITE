<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        try {
            $this->authorize('viewAny', User::class);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'You are not allowed to view users.'
            ], 403);
        }

        $users = User::all();
        return UserResource::collection($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        try {
            $this->authorize('view', $user);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => 'You are not allowed to view this user.'
            ], 403);
        }

        return new UserResource($user);
    }
}
