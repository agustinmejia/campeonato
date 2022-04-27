<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Delegate;

class DelegatesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function print($id){
        $delegate = Delegate::where('id', $id)->with('club')->first();
        return view('delegates.print.credential', compact('delegate'));
        
    }
}
