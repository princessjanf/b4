<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SSO\SSO;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;

class UploadController extends Controller
{
  public function uploadForm()
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
    $idBeasiswa = $request->get('idBeasiswa');
    $idMahasiswa = $request->get('idMahasiswa');

    if(count($request->berkases)>0) {
      foreach ($request->berkases as $index=>$berkas) {
        $idBerkas = $request->idBerkas[$index];
        $file = $idMahasiswa.'-'.$request->nama[$index].'.pdf';
        $oldfile = DB::table('berkas_umum')->where('file', $file)->first();
        if($oldfile == null) {
          DB::insert('INSERT INTO `berkas_umum`(`id_berkas`, `id_mahasiswa`, `file`)
          VALUES (?,?,?)', [$idBerkas, $idMahasiswa, $file]);
        }
        $berkas->storeAs('berkas', $file);
      }
    }
    return redirect($request->link);
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
    $idBeasiswa = $request->get('idBeasiswa');
    $idDirektorat = $request->get('idDirektorat');
    $dokumen = $request->uploadDK;
    if(count($dokumen)>0) {
        $namaDokumen = $idDirektorat.'-'.$idBeasiswa.'-Dokumen Kerjasama.pdf';
        $oldfile = DB::table('dokumen_kerjasama')->where('nama_dokumen', $namaDokumen)->first();
        if($oldfile == null) {
          DB::insert('INSERT INTO `dokumen_kerjasama`(`id_direktorat`, `id_beasiswa`, `nama_dokumen`)
          VALUES (?,?,?)', [$idDirektorat, $idBeasiswa, $namaDokumen]);
        }
        $dokumen->storeAs('dokumen_kerjasama/'.$idBeasiswa, $namaDokumen);
    }
    return redirect('list-beasiswa');
  }
}
