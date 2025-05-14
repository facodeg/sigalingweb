<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    //index Note
    public function index(Request $request)
    {
        //note by user_id
        $notes = Note::where('user_id', $request->user()->id)
            ->orderBY('id', 'desc')
            ->get();
        return response()->json([
            'message' => 'Success',
            'data' => $notes,
            200,
        ]);
    }

    //create store Note request
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'note' => 'required',
        ]);

        $note = new Note();
        $note->user_id = $request->user()->id;
        $note->title = $request->title;
        $note->note = $request->note;
        $note->save();

        return response()->json(
            [
                'message' => 'Note berhasil',
                
            ],
            201,
        );
    }
}
