<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSO\SSO;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

  function index()
  {
    $user = null;
    if(SSO::check())
    $user = SSO::getUser();
    return view('pages.homepage')->withUser($user);
  }

  function login()
  {
    if(!SSO::check())
    SSO::authenticate();
    $user = SSO::getUser();
    return view('pages.homepage')->withUser($user);
  }

  function logout()
  {
    SSO::logout(URL::to('/'));
  }

  function daftarbeasiswa()
  {
    $beasiswas = DB::table('beasiswa')->get();
    return view('pages.daftar-beasiswa')->withBeasiswas($beasiswas);
  }

/*  function addbeasiswa()
  {
    return view('pages.add-beasiswa');
  }*/

  function detailbeasiswa($id)
  {
    $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
    $persyaratans = DB::table('persyaratan')->where('id_beasiswa', $beasiswa->id_beasiswa)->get();
    return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans);
  }
}
