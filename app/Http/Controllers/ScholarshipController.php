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

      public function test(){
        //$idBeasiswa = DB::select('SELECT id_beasiswa FROM beasiswa ORDER BY id_beasiswa DESC LIMIT 1');
          //$data = (array)$idBeasiswa;
        //$categories = DB::table('kategori_beasiswa')->select('nama_kategori')->get();
          //DB::select('select nama_kategori from kategori_beasiswa')->get();
          $counter =5;
          for($i = i;$i<($counter);$i++)
          {
            //DB::insert('insert into `syarat` VALUES (?,?)', [$idBeasiswa->id_beasiswa, $request->get('syarat')]);
            echo "syarat$i";
             //echo $request->get('syarat');
           }
        }



      public function insert(Request $request){


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
