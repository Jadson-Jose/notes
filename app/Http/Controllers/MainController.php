<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

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
        echo "I'm creating new note.";
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);
        echo "I'm editing note with id = $id";
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);
        echo "I'm deleting note with id = $id";
    }
}
