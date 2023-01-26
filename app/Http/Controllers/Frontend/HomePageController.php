<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    public function home() {
       return view('home');      
    }
    public function showProfile(){
        return view('profile');
    }
   
}
