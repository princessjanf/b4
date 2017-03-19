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
        public function test(){
          return view('pages.test');
        }
        public function delete($id){
            DB::update('update `beasiswa` SET flag = 0 WHERE id_beasiswa =?', [$id]);
            return response()->json([
    'name' => 'Abigail',
    'state' => 'CA'
]);
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

      public function edit(Request $request){


          /*insert beasiswa*/
        DB::insert('INSERT INTO `beasiswa`(`nama_beasiswa`, `deskripsi_beasiswa`, `id_kategori`, `tanggal_buka`, `tanggal_tutup`,
                                          `kuota`, `nominal`, `dana`, `public`, `flag`, `syarat`)
                    VALUES (?,?,?,?,?,?,?,?,0,1,"asdsa")',
                    [$request->input('namaBeasiswa'),
                    $request->input('deskripsiBeasiswa'),
                    $request->get('kategoriBeasiswa'),
                    $request->input('tanggalBuka'),
                    $request->input('tanggalTutup'),
                    $request->input('kuota'),
                    $request->input('nominal'),
                    $request->input('totalDana')]
        );
        /*assign pendonor ke beasiswa*/
        $id_pendonor = $request->get('pendonor');
        $idBeasiswa = DB::table('beasiswa')->orderBy('id_beasiswa', 'desc')->first();
        DB::insert('insert into `beasiswa_pendonor` VALUES (?,?)', [$idBeasiswa->id_beasiswa, $id_pendonor]);

        /* ini untuk insert syarat, tergantung konfig db nya*/
         $counter = $request->get('counter');
         for($i = 1;$i<=($counter);$i++)
         {
           DB::insert('insert into `syarat` VALUES (?,?)', [$idBeasiswa->id_beasiswa, $request->input('syarat'.$i)]);
          }
      }
        }
}
