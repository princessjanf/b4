<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use SSO\SSO;

class ScholarshipController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


     public function addbeasiswa()
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
         $jenjang = DB::table('jenjang')->get();
         $fakultas = DB::table('fakultas')->get();

         if($namarole=='Pegawai Universitas'){
           return view('pages.add-beasiswa')->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor)->withJenjang($jenjang)->withFakultasbeasiswa($fakultas);
         }
     }
    public function edit($id)
    {
      /*$user = SSO::getUser();

      $pengguna = DB::table('pegawai')->where('username', $user->username)->first();

      if($pengguna==null){
        return redirect('/');
      }

        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
        if($namarole=='Pegawai Universitas'){
          return view('pages.edit-beasiswa')->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor)->withJenjang($jenjang)->withFakultasbeasiswa($fakultas)->withBeasiswa($beasiswa);
        }
        */
        $kategoribeasiswa = DB::table('kategori_beasiswa')->get();
        $pendonor = DB::table('pendonor')->get();
        $jenjang = DB::table('jenjang')->get();
        $fakultas = DB::table('fakultas')->get();
        $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
        return view('pages.edit-beasiswa', ['kategoribeasiswa' => $kategoribeasiswa, 'pendonor' => $pendonor, 'jenjang'=>$jenjang, 'fakultasbeasiswa'=>$fakultas,'beasiswa'=>$beasiswa]);
        //return view('pages.edit-beasiswa')->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor)->withJenjang($jenjang)->withFakultasbeasiswa($fakultas)->withBeasiswa($beasiswa);
      }

      public function delete($id){
            DB::update('update `beasiswa` SET flag = 0 WHERE id_beasiswa =?', [$id]);
        }

          public function makePublic($id){
              DB::update('update `beasiswa` SET public = 1 WHERE id_beasiswa =?', [$id]);
            }

      public function insertBeasiswa(Request $request){

          /*insert beasiswa*/


        DB::insert('INSERT INTO `beasiswa`(`nama_beasiswa`, `deskripsi_beasiswa`, `id_kategori`, `tanggal_buka`, `tanggal_tutup`,
                                          `kuota`, `nominal`, `dana`, `periode`,  `id_pendonor`, `jangka`, `id_status`, `public`, `flag`)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,2,0,1)',
                    [$request->input('namaBeasiswa'),
                    $request->input('deskripsiBeasiswa'),
                    $request->get('kategoriBeasiswa'),
                    $request->input('tanggalBuka'),
                    $request->input('tanggalTutup'),
                    $request->input('kuota'),
                    $request->input('nominal'),
                    $request->input('totalDana'),
                    $request->input('periode'),
                    $request->get('pendonor'),
                    $request->input('jangka')]
       );
       $idBeasiswa = DB::table('beasiswa')->orderBy('id_beasiswa', 'desc')->first();
         $counter = $request->get('counter');
         for($i = 1;$i<=($counter);$i++)
         {
           DB::insert('insert into `persyaratan` (`id_beasiswa`, `syarat`) VALUES (?,?)', [$idBeasiswa->id_beasiswa, $request->input('syarat'.$i)]);
          }
      }

      public function updateBeasiswa(Request $request){

        DB::table('beasiswa')
            ->where('id_beasiswa', $request->get('idBeasiswa'))
            ->update(['nama_beasiswa' => 1,
                      'nama_beasiswa'=>$request->input('namaBeasiswa'),
                      'deskripsi_beasiswa'=>$request->input('deskripsiBeasiswa'),
                      'id_kategori'=>$request->get('kategoriBeasiswa'),
                      'tanggal_buka'=>$request->input('tanggalBuka'),
                      'tanggal_tutup'=>$request->input('tanggalTutup'),
                      'kuota'=>$request->input('kuota'),
                      'nominal'=>$request->input('nominal'),
                      'dana'=>$request->get('totalDana'),
                      'periode'=>$request->input('periode'),
                      'id_pendonor'=>$request->get('pendonor'),
                      'jangka'=>$request->input('jangka')
                    ]);

        }
}
