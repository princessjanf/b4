<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ScholarshipController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
      public function create(){
        $categories = DB::select('select * from kategori_beasiswa');
        $pendonor = DB::select('select * from pendonor');
          $idBeasiswa = DB::select('SELECT id_beasiswa FROM beasiswa ORDER BY id_beasiswa DESC LIMIT 1');
         return view('pages.createScholarship', ['categories' => $categories, 'pendonor' => $pendonor, 'idBeasiswa' =>$idBeasiswa]);
      }

      public function insert(Request $request){

        /* ini untuk insert syarat, tergantung konfig db nya*/
         $counter = $request->get('counter');
         for($i = 0;$i<($counter);$i++)
         {
           //echo $request->get('syarat');
          }
          /*insert beasiswa*/
          DB::insert('INSERT INTO `beasiswa`(`nama_beasiswa`, `deskripsi_beasiswa`, `kategori`, `tanggal_buka`, `tanggal_tutup`,
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
        $idBeasiswa = DB::select('SELECT * FROM beasiswa ORDER BY id_beasiswa DESC LIMIT 1');
        $id_pendonor = $request->get('pendonor');

          //  DB::insert('insert into `beasiswa_pendonor` VALUES (?,?)', [$idBeasiswa, $id_pendonor]);
      
      }
}
