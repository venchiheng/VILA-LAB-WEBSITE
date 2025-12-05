<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        return Auth::user()->profile;
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

        $validated = $request->validate([
            'image' => 'nullable|string',
            'role_in_lab' => 'nullable|string|max:100',
            'research_area' => 'nullable|string',
            'department' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'bio' => 'nullable|string',
            'social_links' => 'nullable|string',
        ]);

        $profile->fill($validated);
        $profile->save();

        return $profile;
    }
}
