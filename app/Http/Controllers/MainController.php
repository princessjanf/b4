<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSO\SSO;
use Illuminate\Support\Facades\URL;

class MainController extends Controller
{
    function index()
    {
      if(!SSO::check()) {
        $user = null;
        return view('pages.welcome')->withUser($user);
      }
      else{
        $user = SSO::getUser();
        return view('pages.welcome')->withUser($user);
      }
    }

    function login()
    {
      if(!SSO::check())
        SSO::authenticate();
			$user = SSO::getUser();

      return view('pages.beranda')->withUser($user);
    }

    function logout()
    {
      SSO::logout(URL::to('/'));
    }
}
