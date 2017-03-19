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
          $namarole = $role->nama_role_pegawai;
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
        $namarole = $role->nama_role_pegawai;
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
        $namarole = $role->nama_role_pegawai;
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
        $namarole = $role->nama_role_pegawai;

        $kategoribeasiswa = DB::table('kategori_beasiswa')->get();
        $pendonor = DB::table('pendonor')->get();

        if($namarole=='Pegawai Universitas'){
          return view('pages.createScholarship')->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor);
        }
    }

    function detailbeasiswa($id)
    {
      if(!SSO::check())
      {
        $username = 'guest';
        $namarole = 'guest';
      }
      else
      {
        $user = SSO::getUser();
        $username = $user->username;
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='pegawai'){
          $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role_pegawai;
        }
      }
      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      $persyaratans = DB::table('persyaratan')->where('id_beasiswa', $beasiswa->id_beasiswa)->get();

      if ($namarole=='pendonor')
      {
        $isPendonor = false;
        $pendonor = DB::table('beasiswa')
                    ->where('id_beasiswa', $beasiswa->id_beasiswa)
                    ->join('pendonor', 'beasiswa.id_pendonor', '=', 'pendonor.id_pendonor')
                    ->select('pendonor.*')
                    ->first();
        if ($pendonor->username == $user->username)
        {
          $isPendonor = true;
        }

        $pendaftars = DB::table('melamar')
                    ->where('id_beasiswa', $beasiswa->id_beasiswa)
                    ->join('user', 'melamar.username', '=', 'user.username')
                    ->select('melamar.*', 'user.nama')
                    ->get();
        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUsername($username)->withNamarole($namarole)->withPendaftars($pendaftars)->withIspendonor($isPendonor);
      }
      else
      {
        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUsername($username)->withNamarole($namarole);
      }
    }
  }
