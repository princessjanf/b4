<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use SSO\SSO;
use Charts;

class ChartController extends Controller
{
  function statistik()
  {
    $user = SSO::getUser();
    $pengguna = $this->getPengguna($user);
    $namarole = $this->getNamarole($pengguna);
    return view('pages.statistik', compact('user','pengguna','namarole'));

  }
  function penerima()
  {
    $user = SSO::getUser();
    $pengguna = $this->getPengguna($user);
    $namarole = $this->getNamarole($pengguna);
    $chart = Charts::multidatabase('bar', 'highcharts')
                      ->title(" ")
                      ->elementLabel('Jumlah')
                      ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                      ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
                      ->groupBy('nama_beasiswa');
    return view('pages.penerimapendaftar', compact('user','pengguna','namarole', 'chart'));

  }
  function persebaran()
  {
    $user = SSO::getUser();
    $pengguna = $this->getPengguna($user);
    $namarole = $this->getNamarole($pengguna);
    $jenjang =
     Charts::multidatabase('bar', 'highcharts')
            ->title("Persebaran Beasiswa Per Jenjang")
            ->elementLabel('Jumlah Beasiswa')
            ->dataset('Jumlah Beasiswa', DB::table('beasiswa_jenjang_prodi as bjp')->join('beasiswa as b', 'b.id_beasiswa', '=', 'bjp.id_beasiswa')->join('program_studi as ps', 'bjp.id_prodi','=','ps.id_prodi')
                        ->join('jenjang as j', 'j.id_jenjang', '=', 'bjp.id_jenjang')->select('b.id_beasiswa', 'nama_jenjang')->distinct()->get())
            ->groupBy('nama_jenjang');

    $fakultas = Charts::multidatabase('bar', 'highcharts')
                           ->title("Jumlah Beasiswa Per Fakultas")
                           ->elementLabel('Jumlah')
                           ->dataset('Beasiswa', DB::table('beasiswa')
                             ->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa','=','beasiswa.id_beasiswa')
                             ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                             ->join('fakultas','fakultas.id_fakultas','=', 'program_studi.id_fakultas')->select('id_beasiswa', 'nama_fakultas', 'id_fakultas')->distinct()->get())
                           ->groupBy('nama_fakultas');

   $prodi = Charts::multidatabase('bar', 'highcharts')
                          ->title("Jumlah Beasiswa Per Program Studi")
                          ->elementLabel('Jumlah')
                          ->dataset('Beasiswa', DB::table('beasiswa')
                            ->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa','=','beasiswa.id_beasiswa')
                            ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                            ->get())
                          ->groupBy('nama_prodi');

    return view('pages.persebaran', compact('user','pengguna','namarole','jenjang','fakultas','prodi'));


  }

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

      $jenjang = DB::table('beasiswa_jenjang_prodi')->join('beasiswa', 'beasiswa_jenjang_prodi.id_beasiswa', '=','beasiswa.id_beasiswa')
      ->join('jenjang','beasiswa_jenjang_prodi.id_jenjang','=','jenjang.id_jenjang')
      ->select('beasiswa_jenjang_prodi.id_jenjang', 'nama_jenjang')->distinct()->get();


      $namaProdi = [];
      $jumlahBeasiswa = [];
      $arrJenjang = [];
      $jjg = [];
      foreach($jenjang as $index=>$j)
      {
        array_push($jjg, $j->nama_jenjang);
        $jumlahProdi = DB::table('beasiswa')->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa', '=', 'beasiswa.id_beasiswa')
                      ->join('jenjang', 'beasiswa_jenjang_prodi.id_jenjang', '=', 'jenjang.id_jenjang')->join('program_studi', 'program_studi.id_prodi','=','beasiswa_jenjang_prodi.id_prodi')
                      ->where('jenjang.id_jenjang',2)->select('beasiswa_jenjang_prodi.id_prodi', 'nama_prodi')->distinct()->get();

        foreach ($jumlahProdi as $jp)
        {
          echo $jp->id_prodi.' '.$j->id_jenjang.' ';
          $jml = DB::table('beasiswa_jenjang_prodi')->where('id_prodi', $jp->id_prodi)->where('id_jenjang', $j->id_jenjang)->count();
          array_push($namaProdi, $jp->nama_prodi);
          array_push($jumlahBeasiswa, $jml);
          array_push($arrJenjang, $j->nama_jenjang);

        }

        ${'prodi'.$index}= Charts::create('pie', 'highcharts')->title('Persebaran Beasiswa '.$j->nama_jenjang)
                              ->labels($namaProdi)->values($jumlahBeasiswa);



        $namaFakultas = [];
        $jmlBeasiswaFakultas = [];
        $jmlFakultas = DB::table('beasiswa_jenjang_prodi as bjp')->join('beasiswa as b', 'b.id_beasiswa','=','bjp.id_beasiswa')
                      ->where('bjp.id_jenjang', $j->id_jenjang)
                      ->join('jenjang_prodi as jp', 'bjp.id_jenjang', '=', 'jp.id_jenjang')
                      ->join('program_studi as ps', 'ps.id_prodi', '=', 'bjp.id_prodi')
                      ->join('fakultas as f', 'f.id_fakultas', '=', 'ps.id_fakultas')
                      ->select('nama_fakultas', 'f.id_fakultas')->distinct()->get();

        foreach($jmlFakultas as $jf)
        {

          $jml = DB::table('beasiswa_jenjang_prodi as bjp')
                        ->join('program_studi as ps', 'ps.id_prodi', '=', 'bjp.id_prodi')
                        ->join('fakultas as f', 'f.id_fakultas', '=', 'ps.id_fakultas')
                        ->where('f.id_fakultas', $jf->id_fakultas)->where('bjp.id_jenjang', $j->id_jenjang)->select('id_beasiswa')->distinct()->get();
          array_push($namaFakultas, $jf->nama_fakultas);
          array_push($jmlBeasiswaFakultas, count($jml));
        }
        ${'fak'.$index}= Charts::create('pie', 'highcharts')->title('Persebaran Beasiswa '.$j->nama_jenjang)
                              ->labels($namaFakultas)->values($jmlBeasiswaFakultas);


      }
      $chart =
       Charts::multidatabase('bar', 'highcharts')
              ->title("Persebaran Beasiswa Per Jenjang")
              ->elementLabel('Jumlah Beasiswa')
              ->dataset('Jumlah Beasiswa', DB::table('beasiswa')->join('beasiswa_jenjang_prodi as bjp', 'bjp.id_beasiswa','=', 'beasiswa.id_beasiswa')->join('program_studi as ps', 'bjp.id_prodi','=','ps.id_prodi')
                          ->join('jenjang as j', 'j.id_jenjang', '=', 'bjp.id_jenjang')->select('beasiswa.id_beasiswa', 'nama_jenjang')->distinct()->get())
              ->groupBy('nama_jenjang');

      $toreturn = ['user'=>$user, 'chart'=>$chart, 'pengguna'=>$pengguna, 'namarole'=>$namarole, 'countjenjang'=>count($jenjang)];
      $toreturn['namaprodi'] = $namaProdi;
      $toreturn['jumlahbeasiswa'] = $jumlahBeasiswa;
      $toreturn['arrjenjang'] = $arrJenjang;
      $toreturn['jenjang'] = $jjg;

      for ($i = 0; $i<count($jenjang); $i++)
      {
        $var='prodi'.$i;
        $toreturn[$var] = $$var;
        $var='fak'.$i;
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

    function index5() {
      $user = SSO::getUser();
      $pengguna = ChartController::getPengguna($user);
      $namarole = ChartController::getNamarole($pengguna);
      $fakultas = DB::table('fakultas')->pluck('nama_fakultas');
      $fakultas->prepend('Semua Fakultas');
      $selected = "Semua Fakultas";
       $chart = Charts::multidatabase('bar', 'highcharts')
                              ->title("Jumlah Beasiswa Per Fakultas")
                              ->elementLabel('Jumlah')
                              ->dataset('Beasiswa', DB::table('beasiswa')
                                ->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa','=','beasiswa.id_beasiswa')
                                ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                                ->join('fakultas','fakultas.id_fakultas','=', 'program_studi.id_fakultas')->get())
                              ->groupBy('nama_fakultas');

        return view('pages.statistik-beasiswa5', compact('user','pengguna','namarole','chart', 'fakultas', 'selected'));
    }

    function index5filter(Request $request)
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
                               ->title("Persebaran Beasiswa Universitas")
                               ->elementLabel('Jumlah')
                               ->dataset('Beasiswa', DB::table('beasiswa')
                                 ->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa','=','beasiswa.id_beasiswa')
                                 ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                                 ->join('fakultas','fakultas.id_fakultas','=', 'program_studi.id_fakultas')->get())
                               ->groupBy('nama_fakultas');
      } else {
        $chart = Charts::multidatabase('bar', 'highcharts')
                               ->title("Persebaran Beasiswa Di $request->selected")
                               ->elementLabel('Jumlah')
                               ->dataset('Prodi', DB::table('beasiswa')
                                             ->join('beasiswa_jenjang_prodi', 'beasiswa_jenjang_prodi.id_beasiswa','=','beasiswa.id_beasiswa')
                                             ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                                             ->join('fakultas','fakultas.id_fakultas','=', 'program_studi.id_fakultas')
                                             ->where('nama_fakultas',$request->selected)
                                             ->get())
                               ->groupBy('nama_prodi');
      }
      return view('pages.statistik-beasiswa5', compact('user','pengguna','namarole','chart', 'fakultas', 'selected'));
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
      $beasiswa = DB::table('beasiswa')->pluck('dana_pendidikan');
      $beasiswa->prepend('Semua Dana');


      // $beasiswa = DB::table('beasiswa')->join('pendonor','pendonor.id_user','=','beasiswa.id_pendonor')->select('beasiswa.nama_beasiswa')->distinct()->get();
        // $nama = DB::table('user')->where('username',$user->username)->first();
        // $pendonor = DB::table('pendonor')->where('id_user', $nama->id_user)->first();
      // $beasiswa = DB::table('beasiswa')->get();
      // $danaPendidikan = DB::table('beasiswa')->where('dana_pendidikan', $beasiswa->dana_pendidikan)->get();

       $chart = array();
       array_push($chart, Charts::multidatabase('line', 'highcharts')
                              ->title("Jumlah Dana Pendidikan per Pendonor")
                              ->elementLabel('Jumlah')
                              ->dataset('dana_pendidikan', DB::table('beasiswa as b')->where('b.dana_pendidikan', '=', 'b.dana_pendidikan')->get())
                              ->groupBy('id_pendonor')
                            );


      return view('pages.statistik-beasiswa3', compact('user','pengguna','namarole','chart'))->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withBeasiswa($beasiswa);
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
      $table = 0;
      return view('pages.statistik-beasiswa6', compact('user','pengguna','namarole','chart', 'prodi', 'selected', 'table'));
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
        $table = 0;
      } else {
        $chart = Charts::multidatabase('bar', 'highcharts')
        ->title("Jumlah Beasiswa di $request->selected")
        ->elementLabel('Jumlah')
       ->dataset('Beasiswa', DB::table('beasiswa_jenjang_prodi')
                                ->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')
                                ->where('program_studi.nama_prodi','=', $request->selected)
                                ->get())
                              ->groupBy('nama_prodi');
        $table = 1;

        $beasiswas = DB::table('beasiswa')->join('beasiswa_jenjang_prodi', 'beasiswa.id_beasiswa', '=', 'beasiswa_jenjang_prodi.id_beasiswa')->join('pendonor', 'beasiswa.id_pendonor', '=', 'pendonor.id_user')->join('program_studi', 'program_studi.id_prodi', '=', 'beasiswa_jenjang_prodi.id_prodi')->where('nama_prodi',$request->selected)->get();

      }
      return view('pages.statistik-beasiswa6', compact('user','pengguna','namarole','chart', 'prodi', 'selected', 'table', 'beasiswas'));
    }

    function beasiswaPerProdi()
     {
       $user = SSO::getUser();
       $pengguna = $this->getPengguna($user);
       $namarole = $this->getNamarole($pengguna);
       $prodi = DB::table('program_studi')->pluck('nama_prodi');
       $prodi->prepend('Semua Prodi');
       $selected = "Semua Prodi";
       $chart = Charts::multidatabase('bar', 'highcharts')
         ->title("Pendaftar dan Penerima Beasiswa di Semua Prodi")
         ->elementLabel('Jumlah')
         ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
         ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
         ->groupBy('nama_beasiswa');

       return view('pages.statistik-beasiswa7', compact('user','pengguna','namarole','chart', 'prodi', 'selected'));

     }

     function beasiswaPerProdi2(Request $request)
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
         ->title("Pendaftar dan Penerima Beasiswa di Semua Prodi")
         ->elementLabel('Jumlah')
         ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
         ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->get())
         ->groupBy('nama_beasiswa');
       } else {
         $chart = Charts::multidatabase('bar', 'highcharts')
         ->title("Pendaftar dan Penerima Beasiswa di Prodi $request->selected")
         ->elementLabel('Jumlah')
         ->dataset('Penerima', DB::table('penerima_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->join('program_studi as p', 'p.id_prodi','=','m.id_prodi')->where('p.nama_prodi','=',$request->selected)->get())
         ->dataset('Pendaftar', DB::table('pendaftaran_beasiswa as pb')->join('beasiswa as b', 'b.id_beasiswa', '=', 'pb.id_beasiswa')->join('mahasiswa as m', 'm.id_user','=','pb.id_mahasiswa')->join('program_studi as p', 'p.id_prodi','=','m.id_prodi')->where('p.nama_prodi','=',$request->selected)->get())
         ->groupBy('nama_beasiswa');
       }
       return view('pages.statistik-beasiswa7', compact('user','pengguna','namarole','chart', 'prodi', 'selected'));
     }

    function danaBeasiswa()
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);

      if ($namarole == 'Mahasiswa') return view('pages.noaccess', compact('user','pengguna','namarole'));

      $chart = array();

      $data = DB::table('beasiswa as b')
                    ->join('beasiswa_jenjang_prodi as bjp', 'bjp.id_beasiswa', '=', 'b.id_beasiswa')
                    ->join('program_studi as ps', 'ps.id_prodi', '=', 'bjp.id_prodi')
                    ->join('fakultas as f', 'f.id_fakultas', '=', 'ps.id_fakultas')
                    ->select(DB::raw('*, SUM(dana_pendidikan+dana_hidup) AS dana_total'))
                    ->groupBy('nama_fakultas')
                    ->get();

      array_push($chart, Charts::create('bar', 'highcharts')
                   ->title('Dana Beasiswa Per Fakultas')
                   ->elementLabel('Dana (Rp)')
                   ->labels($data->pluck('nama_fakultas'))
                   ->values($data->pluck('dana_total')));

       $data2 = DB::table('beasiswa as b')
                     ->join('beasiswa_jenjang_prodi as bjp', 'bjp.id_beasiswa', '=', 'b.id_beasiswa')
                     ->join('program_studi as ps', 'ps.id_prodi', '=', 'bjp.id_prodi')
                     ->select(DB::raw('*, SUM(dana_pendidikan+dana_hidup) AS dana_total'))
                     ->groupBy('nama_prodi')
                     ->get();

       array_push($chart, Charts::create('bar', 'highcharts')
                    ->title('Dana Beasiswa Per Prodi')
                    ->elementLabel('Dana (Rp)')
                    ->labels($data2->pluck('nama_prodi'))
                    ->values($data2->pluck('dana_total')));

       $data4 = DB::table('beasiswa as b')
                     ->join('pendonor as p', 'b.id_pendonor', '=', 'p.id_user')
                     ->join('beasiswa_jenjang_prodi as bjp', 'bjp.id_beasiswa', '=', 'b.id_beasiswa')
                     ->select(DB::raw('*, SUM(dana_pendidikan+dana_hidup) AS dana_total'))
                     ->groupBy('id_pendonor')
                     ->get();

      array_push($chart, Charts::create('bar', 'highcharts')
                    ->title('Dana Beasiswa Per Pendonor')
                    ->elementLabel('Dana (Rp)')
                    ->labels($data4->pluck('nama_instansi'))
                    ->values($data4->pluck('dana_total')));

      $data3 = DB::table('beasiswa')->join('mata_uang', 'mata_uang.id_mata_uang','=','beasiswa.currency')
                   ->select(DB::raw('*, SUM(dana_pendidikan+dana_hidup) AS dana_total'))
                   ->groupBy('nama_beasiswa')
                   ->get();


      return view('pages.statistik-beasiswa-dana', compact('user','pengguna','namarole','chart', 'data3','chartp'));
    }

    function danastatistik()
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);



      return view('pages.statistik', compact('user','pengguna','namarole','chart'));

    }

    function persebaranPerBeasiswa()
    {
      $user = SSO::getUser();
      $pengguna = ChartController::getPengguna($user);
      $namarole = ChartController::getNamarole($pengguna);
      $beasiswas = DB::table('beasiswa')->orderBy('beasiswa.id_beasiswa', 'desc')->get();
      $selected = DB::table('beasiswa')->orderBy('beasiswa.id_beasiswa', 'desc')->first()->nama_beasiswa;

      $dataset = DB::table('penerima_beasiswa as pb')
                        ->join('beasiswa as b', 'b.id_beasiswa', 'pb.id_beasiswa')
                        ->join('mahasiswa as m', 'pb.id_mahasiswa', 'm.id_user')
                        ->join('fakultas as f', 'm.id_fakultas', 'f.id_fakultas')
                        ->join('user as u', 'm.id_user', 'u.id_user')
                        ->where('b.nama_beasiswa', $selected)
                        ->get();

      $chart = Charts::database($dataset, 'pie', 'highcharts')
                       ->title($selected)
                       ->groupBy('nama_fakultas');

      return view('pages.statistik-persebaranPerBeasiswa', compact('user','pengguna','namarole','chart', 'beasiswas', 'selected', 'dataset'));
    }

    function persebaranPerBeasiswafilter(Request $request)
    {
      $user = SSO::getUser();
      $pengguna = $this->getPengguna($user);
      $namarole = $this->getNamarole($pengguna);
      $selected = $request->selected;
      $beasiswas = DB::table('beasiswa')->orderBy('beasiswa.id_beasiswa', 'desc')->get();

      $dataset = DB::table('penerima_beasiswa as pb')
                        ->join('beasiswa as b', 'b.id_beasiswa', 'pb.id_beasiswa')
                        ->join('mahasiswa as m', 'pb.id_mahasiswa', 'm.id_user')
                        ->join('fakultas as f', 'm.id_fakultas', 'f.id_fakultas')
                        ->join('user as u', 'm.id_user', 'u.id_user')
                        ->where('b.nama_beasiswa', $selected)
                        ->get();

      $chart = Charts::database($dataset, 'pie', 'highcharts')
                       ->title($selected)
                       ->groupBy('nama_fakultas');

      return view('pages.statistik-persebaranPerBeasiswa', compact('user','pengguna','namarole','chart', 'beasiswas', 'selected', 'dataset'));
    }

}
