<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
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
                              ->title("chart fakultas all")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->groupBy('nama_beasiswa')
                            );
      array_push($chart, Charts::multidatabase('bar', 'highcharts')
                              ->title("chart fakultas 1")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->where('m.id_fakultas','=','1')->get())
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->where('m.id_fakultas','=','1')->get())
                              ->groupBy('nama_beasiswa')
                            );
      array_push($chart, Charts::multidatabase('bar', 'highcharts')
                              ->title("chart prodi 2")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->where('m.id_prodi','=','2')->get())
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->where('m.id_prodi','=','2')->get())
                              ->groupBy('nama_beasiswa')
                            );
      array_push($chart, Charts::multidatabase('bar', 'highcharts')
                              ->title("chart pendonor 1")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->where('b.id_pendonor','=','1')->get())
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->where('b.id_pendonor','=','1')->get())
                              ->groupBy('nama_beasiswa')
                            );
      $pendonor = DB::table('pendonor')->get();
      return view('pages.statistik-beasiswa', compact('user','pengguna','namarole','chart','pendonor'));
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

    function chartPendonor(Request $request) {
      $chart = array();
      array_push($chart, Charts::multidatabase('bar', 'highcharts')
                              ->title("chart pendonor 1")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->where('b.id_pendonor','=',$request->get('idPendonor'))->get())
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->where('b.id_pendonor','=',$request->get('idPendonor'))->get())
                              ->groupBy('nama_beasiswa')
                            );
      return response()->json(array('msg'=>$chart), 200);
    }

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

    function index4()
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);
      $fakultas = DB::table('fakultas')->pluck('nama_fakultas');
      $fakultas->prepend('Semua Fakultas');
      $selected = "Semua Fakultas";
      $chart = Charts::multidatabase('bar', 'highcharts')
                              ->title("Beasiswa di Semua Fakultas")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->groupBy('nama_beasiswa');

      return view('pages.statistik-beasiswa4', compact('user','pengguna','namarole','chart', 'fakultas', 'selected'));
    }

    function index4filter(Request $request)
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);
      $fakultas = DB::table('fakultas')->pluck('nama_fakultas');
      $fakultas->prepend('Semua Fakultas');
      $selected = $request->selected;

      if ($selected == "Semua Fakultas")
      {
        $chart = Charts::multidatabase('bar', 'highcharts')
        ->title("Beasiswa di Semua Fakultas")
        ->elementLabel('Jumlah')
        ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
        ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
        ->groupBy('nama_beasiswa');
      } else {
        $chart = Charts::multidatabase('bar', 'highcharts')
        ->title("Beasiswa di $request->selected")
        ->elementLabel('Jumlah')
        ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->join('fakultas as f', 'f.id_fakultas','=','m.id_fakultas')->where('f.nama_fakultas','=',$request->selected)->get())
        ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->join('fakultas as f', 'f.id_fakultas','=','m.id_fakultas')->where('f.nama_fakultas','=',$request->selected)->get())
        ->groupBy('nama_beasiswa');
      }
      return view('pages.statistik-beasiswa4', compact('user','pengguna','namarole','chart', 'fakultas', 'selected'));
    }

    function index6()
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);
      $prodi = DB::table('program_studi')->pluck('nama_prodi');
      $prodi->prepend('Semua Prodi');
      $selected = "Semua Prodi";
      $chart = Charts::multidatabase('bar', 'highcharts')
                              ->title("Jumlah Beasiswa di Semua Prodi")
                              ->elementLabel('Jumlah')
                              ->dataset('Jumlah Beasiswa', DB::table('program_studi as ps')->join('beasiswa_jenjang_prodi as b', 'b.id_prodi', '=', 'ps.id_prodi')->get())
                              ->groupBy('nama_prodi');

      return view('pages.statistik-beasiswa6', compact('user','pengguna','namarole','chart', 'prodi', 'selected'));
    }

    function index6filter(Request $request)
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);
      $prodi = DB::table('program_studi')->pluck('nama_prodi');
      $prodi->prepend('Semua Prodi');
      $selected = $request->selected;

      if ($selected == "Semua Prodi")
      {
        $chart = Charts::multidatabase('bar', 'highcharts')
        ->title("Jumlah Beasiswa di Semua Prodi")
        ->elementLabel('Jumlah')
        ->dataset('Jumlah Beasiswa', DB::table('program_studi as ps')->join('beasiswa_jenjang_prodi as b', 'b.id_prodi', '=', 'ps.id_prodi')->get())
        ->groupBy('nama_prodi');
      } else {
        $chart = Charts::multidatabase('bar', 'highcharts')
        ->title("Jumlah Beasiswa di $request->selected")
        ->elementLabel('Jumlah')
       ->dataset('Beasiswa', DB::table('beasiswa_jenjang_prodi')
                                ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                                ->where('program_studi.nama_prodi','=', $request->selected)
                                ->get())
                              ->groupBy('nama_prodi');
      }
      return view('pages.statistik-beasiswa6', compact('user','pengguna','namarole','chart', 'prodi', 'selected'));
    }

    function beasiswaPerProdi(Request $request)
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);
      $prodi = DB::table('program_studi')->pluck('nama_prodi');
      $prodi->prepend('Semua Prodi');
      $selected = "Semua Prodi";
      $chart = Charts::multidatabase('bar', 'highcharts')
                              ->title("Beasiswa di Semua Prodi")
                              ->elementLabel('Jumlah')
                              ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                              ->groupBy('nama_beasiswa');

      return view('pages.statistik-beasiswa4', compact('user','pengguna','namarole','chart', 'fakultas', 'selected'));
    }
}