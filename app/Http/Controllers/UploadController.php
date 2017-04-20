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

    if($namarole=='pegawai'){
      $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
      $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
      $namarole = $role->nama_role_pegawai;
    }

    return view('pages.upload-form')->withUser($user)->withNamarole($namarole);
  }

  public function uploadSubmit(UploadRequest $request)
  {
    // $product = Product::create($request->all());
    $idBeasiswa = $request->get('idBeasiswa');
    $idBerkas = $request->get('idBerkas');
    $idMahasiswa = $request->get('idMahasiswa');

    foreach ($request->berkases as $index=>$berkas) {
      $file = $berkas->storeAs('berkas', $idMahasiswa.'-'.$request->nama[$index]);

      DB::insert('INSERT INTO `beasiswa_berkas`(`id_beasiswa`, `id_berkas`, `id_mahasiswa`, `file`)
      VALUES (?,?,?,?)',
      [$idBeasiswa, $idBerkas, $idMahasiswa, $file]
    );

    // ProductsPhoto::create([
    //   'product_id' => $product->id,
    //   'filename' => $filename
    // ]);
    }
    return redirect('upload');
  }
}
