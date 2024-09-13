<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // load  user's notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        echo "I'm creating new note.";
    }
}
