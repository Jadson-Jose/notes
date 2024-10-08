<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;
use Mockery\Matcher\Not;

class MainController extends Controller
{
    public function index()
    {
        // load  user's notes
        $id = session('user.id');
        $notes = User::find($id)
            ->notes()
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        // show the view
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            [
                'text_title.required' => 'O título é obrigatório.',
                'text_title.min' => 'O título deve ter pelo menos :min caracteres.',
                'text_title.max' => 'O título deve ter no máximo :max caracteres.',

                'text_note.required' => 'A nota é obrigatória.',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres.',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres.'
            ]
        );

        $id = session('user.id');

        // create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    public function editNote($id)
    {

        $id = Operations::decryptId($id);

        $note = Note::find($id);

        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            [
                'text_title.required' => 'O título é obrigatório.',
                'text_title.min' => 'O título deve ter pelo menos :min caracteres.',
                'text_title.max' => 'O título deve ter no máximo :max caracteres.',

                'text_note.required' => 'A nota é obrigatória.',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres.',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres.'
            ]
        );

        if ($request->note_id == null) {
            return redirect()->route('home');
        }

        // decrypt note_id
        $id = Operations::decryptId($request->note_id);

        // load note
        $note = Note::find($id);

        // update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();


        return redirect()->route('home');
    }

    public function deleteNote($id)
    {

        $id = Operations::decryptId($id);

        // load note
        $note = Note::find($id);

        // show delete note confirmation
        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id)
    {

        // check if $id is encrypted
        $id = Operations::decryptId($id);

        // load note
        $note = Note::find($id);

        // 1. hard delete
        // $note->delete();

        // 2. soft delete
        // $note->deleted_at = date('Y:m:d H:i:s');
        // $note->save();

        // 3. soft deletes (property in model)
        $note->delete();

        // 4. hard delete (property in model)
        // $note->forcedelete();

        return redirect()->route('home');
    }
}
