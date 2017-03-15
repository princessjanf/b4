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

         return view('pages.createScholarship', ['categories' => $categories, 'pendonor' => $pendonor]);
      }

      public function insert(Request $request){
         $name = $request->input('namaBeasiswa');
         echo $name;
      DB::insert('INSERT INTO `beasiswa`(`nama_beasiswa`, `deskripsi_beasiswa`, `kategori`, `tanggal_buka`, `tanggal_tutup`,
                                          `kuota`, `nominal`, `dana`, `public`, `flag`, `syarat`)
                    VALUES (?,?,?,?,?,?,?,?,1,1,?)',
                    [$request->input('namaBeasiswa'),
                    $request->input('deskripsiBeasiswa'),
                    $request->input('kategoriBeasiswa'),
                    $request->input('tanggalBuka'),
                    $request->input('tanggalTutup'),
                    $request->input('kuota'),
                    $request->input('nominal'),
                    $request->input('totalDana'),
                    $request->input('syaratBeasiswa')]


       );
        // DB::insert('insert into kategori_beasiswa (nama_kategori) values(?)',[$name]);
         //echo "Record inserted successfully.<br/>";
         //echo '<a href = "/insert">Click Here</a> to go back.';
        //   return redirect()->route('/');
      }
}
