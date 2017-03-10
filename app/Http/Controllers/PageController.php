<?php

namespace App\Http\Controllers;


class PagesController extends Controller
{
    public function home(){
        return view('welcome');
    }

    public function example(){
    	return view('example');
    }

    public function logout(){
    	return view('logout');
    }

    public function about(){
    	return view('pages.about');
    }
}