<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credentials): array
    {
        $user = User::where('member_id', $credentials['member_id'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'member_id' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }
     public function changePassword(User $user, array $data): void
    {
        // Validate new password confirmation
        if ($data['new_password'] !== $data['new_password_confirmation']) {
            throw ValidationException::withMessages([
                'new_password_confirmation' => ['The new password confirmation does not match.'],
            ]);
        }

        // Check current password
        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        // Update password
        $user->password = Hash::make($data['new_password']);
        $user->save();
    }
}
