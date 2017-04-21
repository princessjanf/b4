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
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
        return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user);
      }
      else{
        $user = SSO::getUser();
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='Pegawai'){
          $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role_pegawai;
        }

          $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
          return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole);
        }

    }

    function login()
    {
      if(!SSO::check())
        SSO::authenticate();
			$user = SSO::getUser();
      $exist = DB::table('user')->where('username', $user->username)->first();
      if ($exist == null)
      {
        DB::insert('INSERT INTO `user`(`username`, `nama`, `email`, `id_role`)
                    VALUES (?,?,?,1)',
                    [
                       $user->username,
                        $user->name,
                        $user->username."@ui.ac.id"
                    ]
                  );
        DB::insert('INSERT INTO `mahasiswa`(`username`, `npm`, `id_fakultas`, `id_prodi`)
                    VALUES (?,?,1,1)',
                    [
                       $user->username,
                        $user->npm
                    ]
                  );
      }
        return redirect('');
    }

    function logout()
    {
      SSO::logout(URL::to('/'));
    }

    function listbeasiswa()
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $beasiswa1 = DB::table('beasiswa')->first();
      $pendonorBeasiswa = DB::table('pendonor')->where('id_user', $beasiswa1->id_pendonor)->first();
      $pendonor_beasiswa = $pendonorBeasiswa->nama_instansi;

      if ($role->nama_role == 'Pegawai')
      {
        $roles = DB::table('role_pegawai')->where('id_role_pegawai', $role->id_role)->first();
        $namarole = $roles->nama_role_pegawai;
      }
      else 
      {
        $namarole = $role->nama_role;
      }

      if($namarole=='Pegawai'){
        $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
      }

      if ($namarole == 'Mahasiswa' || $namarole == 'Pegawai Fakultas') {
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get();
      } else if ($namarole == 'pendonor'){
        $pendonor = DB::table('pendonor')->where('id_user', $pengguna->id_user)->first();
        $beasiswas = collect(DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get());
        $beasiswas2= collect(DB::table('beasiswa')->where('flag', '1')->where('public', '0')->where('id_pendonor', $pendonor->id_pendonor)->get());
        $beasiswas = $beasiswas->merge($beasiswas2)->sort()->values()->all();
      } else {
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->get();
      }
      return view('pages.list-beasiswa')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole)->withPendonorBeasiswa($pendonor_beasiswa);
    }

     function addbeasiswa()
    {
      $user = SSO::getUser();

      $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();

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
    function noaccess()
    {
      if(!SSO::check()) {
        $user = null;
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
        return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user);
      }
      else{
        $user = SSO::getUser();
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='Pegawai'){
          $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role_pegawai;
        }

          $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get();
          return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
        }

    }
    function detailbeasiswa($id)
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='Pegawai'){
        $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
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
        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole)->withPendaftars($pendaftars)->withIspendonor($isPendonor);
      }
      else
      {
        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole);
      }
    }
  }
