<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Http\Resources\ContactMessageResource;


class ContactMessageController extends Controller
{
/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = ContactMessage::latest()->get();
        return ContactMessageResource::collection($messages);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $message = new ContactMessage();
        $message->name = $request->input('name');
        $message->email = $request->input('email');
        $message->phone_number = $request->input('phone_number');
        $message->message = $request->input('message');
        $message->save();
        return $message;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        return new ContactMessageResource($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $message_id)
    {
        //
        $message = ContactMessage::find($message_id);
        $message->delete();
        if (!$message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Message deleted successfully, Here are all deleted messages:',
            'data' => ContactMessage::onlyTrashed()->get()
        ], 200);
    }

    public function restore(string $message_id)
    {
        $message = ContactMessage::withTrashed()->find($message_id);
        if (!$message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message not found'
            ], 404);
        }
        $message->restore();
        return response()->json([
            'status' => 'success',
            'message' => 'Message restored successfully, Here are all messages:',
            'data' => $message = ContactMessage::all()
        ], 200);
    }
}
