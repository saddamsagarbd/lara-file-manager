<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    public function index(){
        if(isset(Auth::user()->name)){
            return view('home');
        }
        return view('auth.login');
    }
}
