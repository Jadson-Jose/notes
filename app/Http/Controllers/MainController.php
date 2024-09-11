<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        echo 'I am insed the app !';
    }

    public function newNote(){
        echo "I'm creating new note.";
    }
}
