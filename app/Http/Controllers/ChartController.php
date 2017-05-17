<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SSO\SSO;
use Charts;

class ChartController extends Controller
{
    function index()
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);

      $chart = array();
      array_push($chart, Charts::multidatabase('bar', 'highcharts')
                              ->title("chart sesuatu")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->groupBy('nama_beasiswa')
                            );
      array_push($chart, Charts::database(DB::table('user')->get(), 'bar', 'highcharts')
                              ->groupBy('username')
                            );

      return view('pages.statistik-beasiswa', compact('user','pengguna','namarole','chart'));
    }

    // Untuk melihat persebaran beasiswa per prodi untuk setiap jenjang
    function statistikAll(){
      $user = SSO::getUser();
      $pengguna = ChartController::getPengguna($user);
      $namarole = ChartController::getNamarole($pengguna);

      $jenjang = DB::table('beasiswa_jenjang_prodi')->join('jenjang','beasiswa_jenjang_prodi.id_jenjang','=','jenjang.id_jenjang')->select('beasiswa_jenjang_prodi.id_jenjang', 'nama_jenjang')->distinct()->get();

      foreach($jenjang as $index=>$j)
      {
        $namaProdi = [];
        $jumlahBeasiswa = [];
        $jumlahProdi = DB::table('beasiswa_jenjang_prodi')->where('id_jenjang', $j->id_jenjang)->join('program_studi', 'program_studi.id_prodi','=','beasiswa_jenjang_prodi.id_prodi')->select('beasiswa_jenjang_prodi.id_prodi', 'nama_prodi')->distinct()->get();
        foreach ($jumlahProdi as $jp)
        {
          $jml = DB::table('beasiswa_jenjang_prodi')->where('id_prodi', $jp->id_prodi)->where('id_jenjang', $j->id_jenjang)->count();
          array_push($namaProdi, $jp->nama_prodi);
          array_push($jumlahBeasiswa, $jml);
        }

        ${'chart'.$index}= Charts::create('pie', 'highcharts')->title('Beasiswa '.$j->nama_jenjang)
                              ->labels($namaProdi)->values($jumlahBeasiswa);

      }
      $chart =
       Charts::multidatabase('bar', 'highcharts')
              ->title("Persebaran Beasiswa Per Prodi")
              ->elementLabel('Jumlah Beasiswa')
              ->dataset('Jumlah Beasiswa Per Program Studi', DB::table('beasiswa_jenjang_prodi as bjp')->join('program_studi as ps', 'bjp.id_prodi','=','ps.id_prodi')
                          ->join('fakultas as f', 'f.id_fakultas', '=', 'ps.id_fakultas')->get())
              ->groupBy('nama_fakultas');

      $toreturn = ['user'=>$user, 'chart'=>$chart, 'pengguna'=>$pengguna, 'namarole'=>$namarole, 'countjenjang'=>count($jenjang)];

      // $toreturn = ['namarole'=>$chk];
      //compact('user','pengguna','namarole','chart0');
      for ($i = 0; $i<count($jenjang); $i++)
      {
        $var='chart'.$i;
        $toreturn[$var] = $$var;

      }
       return view('pages.statistik-beasiswa2',$toreturn);

    }

    function jumlahBeasiswaFakultas() {
      $user = SSO::getUser();
      $pengguna = ChartController::getPengguna($user);
      $namarole = ChartController::getNamarole($pengguna);

       $chart = Charts::multidatabase('bar', 'highcharts')
                              ->title("Jumlah Beasiswa Per Fakultas")    
                              ->elementLabel('Jumlah')
                              ->dataset('Beasiswa', DB::table('beasiswa')
                                ->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa','=','beasiswa.id_beasiswa')
                                ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                                ->join('fakultas','fakultas.id_fakultas','=', 'program_studi.id_fakultas')->get())
                              ->groupBy('nama_fakultas');

        return view('pages.statistik-beasiswa5', compact('user','pengguna','namarole','chart'));
    }

    function jumlahBeasiswaProdi() {
      $user = SSO::getUser();
      $pengguna = ChartController::getPengguna($user);
      $namarole = ChartController::getNamarole($pengguna);

       $chart = Charts::multidatabase('bar', 'highcharts')
                              ->title("Jumlah Beasiswa Per Program Studi")    
                              ->elementLabel('Jumlah')
                              ->dataset('Beasiswa', DB::table('beasiswa')
                                ->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa','=','beasiswa.id_beasiswa')
                                ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                                ->get())
                              ->groupBy('nama_prodi');

        return view('pages.statistik-beasiswa5', compact('user','pengguna','namarole','chart'));
    }

    function pendaftarFakultas() {
      $user = SSO::getUser();
      $pengguna = ChartController::getPengguna($user);
      $namarole = ChartController::getNamarole($pengguna);

 // if ($namarole=='Pendonor'){
  // return var_dump($pengguna->id_user);
        // $pendonor = DB::table('pendonor')->where('id_user', $pengguna->id_user)->first();
        //get nama dan nilai pendaftar beasiswa untuk tahap ini
        // $beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
        // $penerima = DB::table('penerima_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)->get();

      $beasiswa = DB::table('beasiswa')->join('pendonor','pendonor.id_user','=','beasiswa.id_pendonor')->select('beasiswa.nama_beasiswa')->distinct()->get();

// return var_dump($beasiswa);
      // $namabeasiswa = DB::table('beasiswa')
      //   ->whereIn('id_beasiswa', $beasiswa->pluck('id_beasiswa'))
      //   ->where('id_pendonor', $idPendonor)
      //   ->join('pendonor', 'pendonor.id_user', '=', 'beasiswa.id_pendonor')
      //   ->select('beasiswa.*')
      //   ->get();
        // return view('pages.nama-penerima')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withBeasiswa($beasiswa)->withPenerima($penerima)->withNamapenerima($namaPenerima);
// return var_dump(DB::table('pendaftaran_beasiswa as pb')->join('mahasiswa as m', 'm.id_user', '=', 'pb.id_mahasiswa')->join('fakultas as f', 'f.id_fakultas', '=', 'm.id_fakultas')->join('beasiswa', 'beasiswa.id_beasiswa', '=', 'pb.id_beasiswa')->get());
       $chart = array();
       array_push($chart, Charts::multidatabase('bar', 'highcharts')
                              ->title("Jumlah Pendaftar Per Fakultas")    
                              ->elementLabel('Jumlah')
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('mahasiswa as m', 'm.id_user', '=', 'pb.id_mahasiswa')->join('fakultas as f', 'f.id_fakultas', '=', 'm.id_fakultas')->join('beasiswa', 'beasiswa.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->groupBy('nama_fakultas')
                            );
      

      return view('pages.statistik-beasiswa3', compact('user','pengguna','namarole','chart'))->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withBeasiswa($beasiswa);
    }
  // }

    function getPengguna($user)
    {
        $pengguna = DB::table('user')->where('username', $user->username)->first();

        return $pengguna;
    }

    function getNamarole($pengguna)
    {
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='Pegawai'){
        $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
      }

      return $namarole;
    }
}
