<?php

namespace App\Http\Controllers;

use App\Models\ContactResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactResponseController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message_id' => 'required|exists:contact_messages,id',
            'response_text' => 'required|string',
        ]);

        $validated['admin_id'] = Auth::id();

        return ContactResponse::create($validated);
    }

    public function show(ContactResponse $contactResponse)
    {
        return $contactResponse->load(['message', 'admin']);
    }
}
