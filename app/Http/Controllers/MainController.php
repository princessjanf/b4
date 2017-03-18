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

        return view('pages.beranda')->withUser($user);
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

     function addbeasiswa()
    {
      return view('pages.add-beasiswa');
    }

    function detailbeasiswa($id)
    {
      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      $pendonor = DB::table('pendonor')->where('id_pendonor', $beasiswa->id_pendonor)->first();
      return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPendonor($pendonor);
    }
}
