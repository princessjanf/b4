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
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='pegawai'){
          $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role;
        }

        //$namarole disini kemungkinannya berarti = mahasiswa/pendonor/pegawai fakultas/pegawai universitas/direktorat kerjasama
          return view('pages.homepage')->withUser($user)->withNamarole($namarole);
        }

    }

    function login()
    {
      if(!SSO::check())
        SSO::authenticate();
			$user = SSO::getUser();

      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='pegawai'){
        $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role;
      }

      //$namarole disini kemungkinannya berarti = mahasiswa/pendonor/pegawai fakultas/pegawai universitas/direktorat kerjasama
        return view('pages.homepage')->withUser($user)->withNamarole($namarole);
    }

    function logout()
    {
      SSO::logout(URL::to('/'));
    }

    function daftarbeasiswa()
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='pegawai'){
        $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role;
      }

      //$namarole disini kemungkinannya berarti = mahasiswa/pendonor/pegawai fakultas/pegawai universitas/direktorat kerjasama
      $beasiswas = DB::table('beasiswa')->get();
      return view('pages.daftar-beasiswa')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole);
    }

     function addbeasiswa()
    {
      $user = SSO::getUser();

      $pengguna = DB::table('pegawai')->where('username', $user->username)->first();

      if($pengguna==null){
        return redirect('/');
      }
        
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role;

        if($namarole=='Pegawai Universitas'){
          return view('pages.add-beasiswa');
        }
    }

    function detailbeasiswa($id)
    {
      $user = SSO::getUser();

      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='pegawai'){
        $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role;
      }

      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      $pendonor = DB::table('pendonor')->where('id_pendonor', $beasiswa->id_pendonor)->first();
      return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPendonor($pendonor)->withUser($user)->withNamarole($namarole);
    }
}
