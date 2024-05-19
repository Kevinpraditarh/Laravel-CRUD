<?php

// app/Http/Controllers/NoteController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller {
    public function __construct() {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $note = Note::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json($note, 201);
    }

    public function show($id) {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        return response()->json($note, 200);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->update($request->only('title', 'description'));

        return response()->json($note, 200);
    }

    public function destroy($id) {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);
        $note->delete();

        return response()->noContent();
    }
}
