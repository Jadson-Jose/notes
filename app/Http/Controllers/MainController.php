<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // load  user's notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        // show the view
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        echo "I'm creating a new note.";
    }

    public function editNote($id)
    {
 032
        $id = Operations::decryptId($id);
        001
        echo "I'm editing note with id = $id";
    }

    public function deleteNote($id)
    {
 032
        $id = Operations::decryptId($id);
        echo "I'm deleting note with id = $id";


        echo "I'm deleting note with id = $id";
    }

    private function decryptId($id){
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }

        return $id;
 001
    }
}
