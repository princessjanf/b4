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
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();

      if($pengguna==null){
        return redirect('noaccess');
      }

      $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
      $namarole = $role->nama_role_pegawai;

      $kategoribeasiswa = DB::table('kategori_beasiswa')->get();
      $pendonor = DB::table('pendonor')->get();
      $jenjang = DB::table('jenjang')->get();
      $berkas = DB::table('berkas')->get();
      $fakultas = DB::table('fakultas')->get();
      $jenisseleksi = DB::table('jenis_seleksi')->get();

      $pegawaiuniversitas = (DB::table('user')
      ->join('pegawai', 'user.id_user', '=', 'pegawai.id_user')
      ->join('pegawai_universitas', 'pegawai_universitas.id_user', '=', 'pegawai.id_user')
      ->where('pegawai.id_role_pegawai', 1))->join('jabatan', 'jabatan.id_jabatan', '=', 'pegawai.id_jabatan')
      ->get();

      $pegawaifakultas = ((DB::table('user')
          ->join('pegawai', 'user.id_user', '=', 'pegawai.id_user')
          ->join('pegawai_fakultas', 'pegawai_fakultas.id_user', '=', 'pegawai.id_user')
          ->where('pegawai.id_role_pegawai', 2))
        ->join('fakultas', 'fakultas.id_fakultas', '=','pegawai_fakultas.kode_fakultas'))
      ->join('jabatan', 'jabatan.id_jabatan', '=', 'pegawai.id_jabatan')
      ->get();

      if($namarole=='Pegawai Universitas'){
        return view('pages.add-beasiswa')->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor)->withBerkas($berkas)->withJenjang($jenjang)->withFakultasbeasiswa($fakultas)->withJenisseleksi($jenisseleksi)->withPegawaiuniversitas($pegawaiuniversitas)->withPegawaifakultas($pegawaifakultas);
      }
      else{
        return redirect('noaccess');
      }
    }
    public function edit($id)
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();

      if($pengguna==null){
        return redirect('noaccess');
      }

      $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
      $namarole = $role->nama_role_pegawai;

      $kategoribeasiswa = DB::table('kategori_beasiswa')->get();
      $pendonor = DB::table('pendonor')->get();
      $jenjang = DB::table('jenjang')->get();
      $berkas = DB::table('berkas')->get();
      $fakultas = DB::table('fakultas')->get();
      $jenisseleksi = DB::table('jenis_seleksi')->get();

      $pegawaiuniversitas = (DB::table('user')
      ->join('pegawai', 'user.id_user', '=', 'pegawai.id_user')
      ->join('pegawai_universitas', 'pegawai_universitas.id_user', '=', 'pegawai.id_user')
      ->where('pegawai.id_role_pegawai', 1))->join('jabatan', 'jabatan.id_jabatan', '=', 'pegawai.id_jabatan')
      ->get();

      $pegawaifakultas = ((DB::table('user')
          ->join('pegawai', 'user.id_user', '=', 'pegawai.id_user')
          ->join('pegawai_fakultas', 'pegawai_fakultas.id_user', '=', 'pegawai.id_user')
          ->where('pegawai.id_role_pegawai', 2))
        ->join('fakultas', 'fakultas.id_fakultas', '=','pegawai_fakultas.kode_fakultas'))
      ->join('jabatan', 'jabatan.id_jabatan', '=', 'pegawai.id_jabatan')
      ->get();

      $beasiswa = DB::table('beasiswa')->join('beasiswa_jenjang_prodi', 'beasiswa.id_beasiswa', '=', 'beasiswa_jenjang_prodi.id_beasiswa')->where('beasiswa.id_beasiswa', $id)->first();
      if($namarole=='Pegawai Universitas'){
        return view('pages.edit-beasiswa')->withBeasiswa($beasiswa)->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor)->withBerkas($berkas)->withJenjang($jenjang)->withFakultasbeasiswa($fakultas)->withJenisseleksi($jenisseleksi)->withPegawaiuniversitas($pegawaiuniversitas)->withPegawaifakultas($pegawaifakultas);
      }
      else{
        return redirect('noaccess');
      }
    }

    public function daftarBeasiswa($id)
    {
      echo "dummy method untuk daftar beasiswa".$id;
      /*$user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();

      if($pengguna==null){
        return redirect('noaccess');
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
      else{
        return redirect('noaccess');
      }*/
    }
    public function delete($id){
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();

      if($pengguna==null){
        return redirect('noaccess');
      }

      $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
      $namarole = $role->nama_role_pegawai;

      if($namarole=='Pegawai Universitas'){
      DB::update('update `beasiswa` SET flag = 0 WHERE id_beasiswa =?', [$id]);
      return redirect('/list-beasiswa');
      }
      else {
        return redirect('noaccess');
      }
    }

    public function makePublic($id){
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();

      if($pengguna==null){
        return redirect('noaccess');
      }

      $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
      $namarole = $role->nama_role_pegawai;

      if($namarole=='Pegawai Universitas'){
      DB::update('update `beasiswa` SET public = 1 WHERE id_beasiswa =?', [$id]);
      return redirect('/list-beasiswa');}
      else{
        return redirect('noaccess');
      }
    }
    public function retrieveProdi(Request $request)
    {
            $jenjang = $request ->get('jenjang');

            // select id_prodi from jenjang_prodi where id_jenjang = jenjang
            // select id_fakultas, id_prodi, nama_prodi from program_studi where id_prodi = id_prodisblmnya
            // select id_fakultas, nama_fakultas where id_fakultas = id_fakultas sblmnya
            $msg = DB::table('jenjang_prodi')
            ->where('id_jenjang',$jenjang)->join('program_studi', 'jenjang_prodi.id_prodi', '=', 'program_studi.id_prodi')
            ->join('fakultas', 'program_studi.id_fakultas','=','fakultas.id_fakultas')
            ->select('program_studi.id_prodi', 'program_studi.nama_prodi', 'fakultas.id_fakultas', 'fakultas.nama_fakultas')
            ->orderBy('id_fakultas', 'asc')->get();
            //echo $msg;
            return $msg;
    }

    public function filterPegawaiFakultas(Request $request)
    {
            $idFakultas = $request ->get('idFakultas');

            $msg = ((DB::table('user')
                ->join('pegawai', 'user.id_user', '=', 'pegawai.id_user')
                ->join('pegawai_fakultas', 'pegawai_fakultas.id_user', '=', 'pegawai.id_user')
                ->where('pegawai.id_role_pegawai', 2))
              ->join('fakultas', 'fakultas.id_fakultas', '=','pegawai_fakultas.kode_fakultas'))
            ->join('jabatan', 'jabatan.id_jabatan', '=', 'pegawai.id_jabatan')->where('pegawai_fakultas.kode_fakultas',$idFakultas)
            ->get();

            return $msg;
    }

    public function insertBeasiswa(Request $request){
      // Memasukkan Beasiswa
      DB::insert('INSERT INTO `beasiswa`(`nama_beasiswa`, `deskripsi_beasiswa`, `id_kategori`, `tanggal_buka`, `tanggal_tutup`,
                                        `kuota`, `nominal`, `dana_pendidikan`, `dana_hidup`, `periode`,  `id_pendonor`, `jangka`, `currency`, `id_jenis_seleksi`, `link_seleksi`, `waktu_tagih`, `id_status`, `public`, `flag`,`dokumen_publik`,`dokumen_internal`)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,0,1,"#","#")',
                  [$request->input('namaBeasiswa'),
                  $request->input('deskripsiBeasiswa'),
                  $request->get('kategoriBeasiswa'),
                  $request->input('tanggalBuka'),
                  $request->input('tanggalTutup'),
                  $request->input('kuota'),
                  $request->input('nominal'),
                  $request->input('danaPendidikan'),
                  $request->input('danaHidup'),
                  $request->input('periode'),
                  $request->get('pendonor'),
                  $request->input('jangka'),
                  $request->get('mataUang'),
                  $request->get('jenisSeleksi'),
                  $request->input('websiteSeleksi'),
                  $request->input('waktuTagih')
                ]
                );

      // Memasukkan syarat-syarat
      $beasiswa = DB::table('beasiswa')->orderBy('id_beasiswa', 'desc')->first();
      $arrSyarat = explode(",",$request->get('arraySyarat'));
      for($i = 0;$i < sizeof($arrSyarat);$i++)
      {
        DB::insert('INSERT INTO `persyaratan` (`id_beasiswa`, `syarat`) VALUES (?,?)',
        [$beasiswa->id_beasiswa, $request->input('syarat'.$arrSyarat[$i])]);
      }

      // Memasukkan beasiswa-jenjang-prodi
      $request->get('listProdi');
      $hasil = explode(",",$request->get('listProdi'));
      $jenjang = $request->get('jenjangBeasiswa');
      for ($i = 0; $i < sizeof($hasil) ; $i++){
        DB::insert('INSERT INTO `beasiswa_jenjang_prodi` (`id_beasiswa`, `id_jenjang`, `id_prodi`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, $jenjang, $hasil[$i]]);
        echo $hasil[$i];
      }

      // Memasukkan log pembuatan beasiswa
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();

        DB::insert('INSERT INTO `log_beasiswa` (`id_beasiswa`, `tipe_perubahan`, `id_user`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, 'initial setup', $pengguna->id_user]);

      // Memasukkan assignment berkas beasiswa
      $listBerkas = explode(",",$request->get('listBerkas'));
      for ($i = 0; $i < sizeof($listBerkas) ; $i++){
        DB::insert('INSERT INTO `assignment_berkas_beasiswa` (`id_berkas`,`id_beasiswa`) VALUES (?,?)',[$listBerkas[$i], $beasiswa->id_beasiswa]);
      }

      // Memasukkan beasiswa penyeleksi
      $arrayTahapan = explode(",",$request->get('arrayTahapan'));
      //Jika penilaian di luar sistem
      if ($arrayTahapan==null) {
        DB::insert('INSERT INTO `beasiswa_penyeleksi` (`id_beasiswa`, `id_penyeleksi`) VALUES (?,?)' , [$beasiswa->id_beasiswa, $request->get('penyeleksi')]);
      }

      //Jika penilaian di luar sistem (banyak tahapan)
      // Memasukkan beasiswa penyeleksi tahapan
      else{
        for ($i = 0; $i < sizeof($arrayTahapan); $i++){
          if($arrayTahapan[$i]==1){
            DB::insert('INSERT INTO `beasiswa_penyeleksi` (`id_beasiswa`, `id_penyeleksi`) VALUES (?,?)' , [$beasiswa->id_beasiswa, $request->get('penyeleksi1')]);
            $bp = DB::table('beasiswa_penyeleks i')->orderBy('id_bpt', 'desc')->first();
            DB::insert('INSERT INTO `beasiswa_penyeleksi_tahapan` (`id_bp`, `id_tahapan`) VALUES (?,?)', [$bp->id_bp, $arrayTahapan[$i]]);
          }elseif ($arrayTahapan[$i]==2) {
            DB::insert('INSERT INTO `beasiswa_penyeleksi` (`id_beasiswa`, `id_penyeleksi`) VALUES (?,?)' , [$beasiswa->id_beasiswa, $request->get('penyeleksi2')]);
            $bp = DB::table('beasiswa_penyeleksi')->orderBy('id_bpt', 'desc')->first();
            DB::insert('INSERT INTO `beasiswa_penyeleksi_tahapan` (`id_bp`, `id_tahapan`) VALUES (?,?)', [$bp->id_bp, $arrayTahapan[$i]]);
          }elseif ($arrayTahapan[$i]==3) {
            DB::insert('INSERT INTO `beasiswa_penyeleksi` (`id_beasiswa`, `id_penyeleksi`) VALUES (?,?)' , [$beasiswa->id_beasiswa, $request->get('penyeleksi3')]);
            $bp = DB::table('beasiswa_penyeleksi')->orderBy('id_bpt', 'desc')->first();
            DB::insert('INSERT INTO `beasiswa_penyeleksi_tahapan` (`id_bp`, `id_tahapan`) VALUES (?,?)', [$bp->id_bp, $arrayTahapan[$i]]);
          }elseif ($arrayTahapan[$i]==4) {
            DB::insert('INSERT INTO `beasiswa_penyeleksi` (`id_beasiswa`, `id_penyeleksi`) VALUES (?,?)' , [$beasiswa->id_beasiswa, $request->get('penyeleksi4')]);
            $bp = DB::table('beasiswa_penyeleksi')->orderBy('id_bpt', 'desc')->first();
            DB::insert('INSERT INTO `beasiswa_penyeleksi_tahapan` (`id_bp`, `id_tahapan`) VALUES (?,?)', [$bp->id_bp, $arrayTahapan[$i]]);
          }
        }
      }
      return redirect('/detail-beasiswa/'.$beasiswa->id_beasiswa);
    }

    public function updateBeasiswa(Request $request){

      DB::table('beasiswa')
          ->where('id_beasiswa', $request->get('idBeasiswa'))
          ->update(['nama_beasiswa'=>$request->input('namaBeasiswa'),
                    'deskripsi_beasiswa'=>$request->input('deskripsiBeasiswa'),
                    'id_kategori'=>$request->get('kategoriBeasiswa'),
                    'tanggal_buka'=>$request->input('tanggalBuka'),
                    'tanggal_tutup'=>$request->input('tanggalTutup'),
                    'kuota'=>$request->input('kuota'),
                    'nominal'=>$request->input('nominal'),
                    'dana_pendidikan'=>$request->get('danaPendidikan'),
                    'dana_hidup'=>$request->get('danaHidup'),
                    'periode'=>$request->input('periode'),
                    'id_pendonor'=>$request->get('pendonor'),
                    'jangka'=>$request->input('jangka'),
                    'currency'=>$request->get('mataUang'),
                    'jenis_seleksi'=>$request->get('jenisSeleksi'),
                    'link_seleksi'=>$request->input('websiteSeleksi'),
                    'waktu_tagih'=>$request->input('waktuTagih')
                  ]);

          DB::table('persyaratan')
              ->where('id_beasiswa', $request->get('idBeasiswa'))
              ->update(['nama_beasiswa'=>$request->input('namaBeasiswa'),
                        'jenis_seleksi'=>$request->get('jenisSeleksi'),
                        'link_seleksi'=>$request->input('websiteSeleksi'),
                        'waktu_tagih'=>$request->input('waktuTagih')
                      ]);

          $user = SSO::getUser();
          $pengguna = DB::table('user')->where('username', $user->username)->first();

          DB::insert('INSERT INTO `log_beasiswa` (`id_beasiswa`, `tipe_perubahan`, `id_user`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, 'modifikasi', $pengguna->id_user]);

          return redirect('/detail-beasiswa/'.$idBeasiswa);
      }

}
