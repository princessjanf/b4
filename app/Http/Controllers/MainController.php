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
        return view('pages.homepage')->withUser($user);
      }
      else{
        $user = SSO::getUser();
        return view('pages.homepage')->withUser($user);
      }

    }

    function login()
    {
      if(!SSO::check())
        SSO::authenticate();
			$user = SSO::getUser();

        return view('pages.daftar-beasiswa')->withUser($user);
    }

    function logout()
    {
      SSO::logout(URL::to('/'));
    }

    function daftarbeasiswa()
    {
      return view('pages.daftar-beasiswa');
    }

     function addbeasiswa()
    {
      return view('pages.add-beasiswa');
    }

}
