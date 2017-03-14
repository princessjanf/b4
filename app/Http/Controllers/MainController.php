<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSO\SSO;
use Illuminate\Support\Facades\URL;

class MainController extends Controller
{
    function index()
    {
      return view('pages.welcome');
    }

    function login()
    {
      if(!SSO::check())
        SSO::authenticate();
			$user = SSO::getUser();

      return view('pages.example')->withUser($user);
    }

    function logout()
    {
      SSO::logout(URL::to('/'));
    }
}
