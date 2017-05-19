<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSO\SSO;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use Redirect;
use Session;

class UploadController extends Controller
{
  public function uploadForm()
  {
    $user = SSO::getUser();
    $pengguna = DB::table('user')->where('username', $user->username)->first();
    $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
    $namarole = $role->nama_role;

    if($namarole=='Pegawai'){
      $pegawai = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
      $role = DB::table('role_pegawai')->where('id_role_pegawai', $pegawai->id_role_pegawai)->first();
      $namarole = $role->nama_role_pegawai;
    }

    $nomorberkasumum = [20,19,10,9,3];
    $berkas = DB::table('berkas')
                      ->whereIn('id_berkas', $nomorberkasumum)
                      ->get();
    $link = 'profil';
    $link2 = 'profil';
    return view('pages.upload-berkas-umum', compact('user','pengguna','namarole','berkas','link','link2'));
  }

  public function uploadSubmit(UploadRequest $request)
  {
    $username = $request->get('username');
    $idBeasiswa = $request->get('idBeasiswa');
    $idMahasiswa = $request->get('idMahasiswa');

    if(count($request->berkases)>0) {
      foreach ($request->berkases as $index=>$berkas) {
        $idBerkas = $request->idBerkas[$index];
        $namaberkas = $request->nama[$index];
        $file = $request->nama[$index].'.pdf';
        $oldfile = DB::table('berkas_umum')->where('file', $file)->first();
        if($oldfile == null) {
          DB::insert('INSERT INTO `berkas_umum`(`id_berkas`, `id_mahasiswa`, `file`)
          VALUES (?,?,?)', [$idBerkas, $idMahasiswa, $file]);
        }
        $berkas->storeAs('berkas/'.$username, $file);
      }
      return redirect($request->get('link'))->with('namaberkas', $namaberkas);
    }
  }

  //Alvin Sprint 3
  public function unggahDokumenKerjasama($idBeasiswa)
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

    if($namarole=='Direktorat Kerjasama'){
      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $idBeasiswa)->first();

    }else {
      return redirect('noaccess');
    }

    return view('pages.unggah-dokumen-kerjasama', compact('user','pengguna','beasiswa','namarole'));
  }

  public function unggahDKsubmit(UploadRequest $request)
  {
    $idbeasiswa = $request->get('idBeasiswa');
    $namabeasiswa = $request->get('namaBeasiswa');
    $iddirektorat = $request->get('idDirektorat');
    $dokumen = $request->DokumenKerjasama;
    if(count($dokumen)>0) {
        $namadokumen = $iddirektorat.'-'.$idbeasiswa.'-Dokumen Kerjasama.pdf';
        $oldfile = DB::table('dokumen_kerjasama')->where('nama_dokumen', $namadokumen)->first();
        if($oldfile == null) {
          DB::insert('INSERT INTO `dokumen_kerjasama`(`id_direktorat`, `id_beasiswa`, `nama_dokumen`)
          VALUES (?,?,?)', [$iddirektorat, $idbeasiswa, $namadokumen]);
          $dokumen->storeAs('dokumen_kerjasama/'.$idbeasiswa, $namadokumen);
          return redirect('list-beasiswa')->with('namabeasiswa', $namabeasiswa)->with('namadokumen', $namadokumen);
        }else{
          $dokumen->storeAs('dokumen_kerjasama/'.$idbeasiswa, $namadokumen);
          return redirect('list-beasiswa')->with('namabeasiswatimpa', $namabeasiswa)->with('namadokumentimpa', $namadokumen);
        }
    }
  }
}
