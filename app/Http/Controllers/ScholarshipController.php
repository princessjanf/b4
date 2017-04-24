<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UploadRequest;
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
      $fakultas = DB::table('fakultas')->get();
      $jenisseleksi = DB::table('jenis_seleksi')->get();

      $pegawaiuniversitas = DB::table('user')->join('pegawai', 'user.id_user', '=', 'pegawai.id_user')->where('pegawai.id_role_pegawai', 1)->get();
      $pegawaifakultas = DB::table('user')->join('pegawai', 'user.id_user', '=', 'pegawai.id_user')->where('pegawai.id_role_pegawai', 2)->get();

      if($namarole=='Pegawai Universitas'){
        return view('pages.add-beasiswa')->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor)->withJenjang($jenjang)->withFakultasbeasiswa($fakultas)->withJenisseleksi($jenisseleksi)->withPegawaiuniversitas($pegawaiuniversitas)->withPegawaifakultas($pegawaifakultas);
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
      $pendonor = DB::table('pendonor')->where('username', $user->username)->first();

      if ($pengguna != null){
      $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
      $namarole = $role->nama_role_pegawai;
      }
      else if ($pendonor !=null)
      {
        $entriPendonor = DB::table('user')->where('id_user', $pendonor->id_user)->first();
        $role = DB::table('role')->where('id_role', $entriPendonor->id_role)->first();
        $namarole = $role->nama_role;
      }
      else{
        return redirect('noaccess');
      }
      $kategoribeasiswa = DB::table('kategori_beasiswa')->get();
      $pendonor = DB::table('pendonor')->get();
      $jenjang = DB::table('jenjang')->get();
      $fakultas = DB::table('fakultas')->get();
      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      if($namarole=='Pegawai Universitas' || $namarole=="pendonor"){
        return view('pages.edit-beasiswa')->withBeasiswa($beasiswa)->withUser($user)->withNamarole($namarole)->withKategoribeasiswa($kategoribeasiswa)->withPendonor($pendonor)->withJenjang($jenjang)->withFakultasbeasiswa($fakultas);

      }
      else{
        return redirect('noaccess');
      }
    }

    public function daftarBeasiswa($id)
      {
          $user = SSO::getUser();
          $pengguna = DB::table('user')->where('username', $user->username)->first();
          $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
          $namarole = $role->nama_role;

          $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
          $mahasiswa = DB::table('mahasiswa')->where('id_user', $pengguna->id_user)->first();

          $bp = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $beasiswa->id_beasiswa)->first();
          $id_penyeleksi = $bp->id_penyeleksi;

          $bepe = DB::table('beasiswa_penyeleksi_tahapan')
                              ->where('beasiswa_penyeleksi_tahapan.id_bp', $bp->id_bp)
                              ->join('beasiswa_penyeleksi', 'beasiswa_penyeleksi.id_bp', '=', 'beasiswa_penyeleksi_tahapan.id_bp')
                              ->select('beasiswa_penyeleksi.id_penyeleksi', 'beasiswa_penyeleksi_tahapan.id_tahapan')
                              ->first();
                              // return var_dump($bepe->id_penyeleksi);


          if($namarole=='Mahasiswa' && $beasiswa->public == 1){
            $nomorberkasumum = [20,19,11,10,3];

            $berkasumum = DB::table('assignment_berkas_beasiswa')
                                  ->whereIn('berkas.id_berkas', $nomorberkasumum)
                                  ->where('id_beasiswa', $id)
                                  ->join('berkas', 'berkas.id_berkas', '=', 'assignment_berkas_beasiswa.id_berkas')
                                  ->select('berkas.*')
                                  ->get();

            $berkasumumup = DB::table('berkas_umum')
                                  ->whereIn('berkas_umum.id_berkas', $berkasumum->pluck('id_berkas'))
                                  ->where('id_mahasiswa', $pengguna->id_user)
                                  ->get();
            //reminderneedbugfix
            if (count($berkasumum) != count($berkasumumup)) {
              return 'lengkapi berkas umum '.$berkasumum->pluck('nama_berkas'). ' di profil';
            }

            $berkas = DB::table('assignment_berkas_beasiswa')
                                  ->whereNotIn('berkas.id_berkas', $nomorberkasumum)
                                  ->where('id_beasiswa', $id)
                                  ->join('berkas', 'berkas.id_berkas', '=', 'assignment_berkas_beasiswa.id_berkas')
                                  ->select('berkas.*')
                                  ->get();

            return view('pages.daftar-beasiswa')->withBeasiswa($beasiswa)->withUser($user)->withNamarole($namarole)->withPengguna($pengguna)->withMahasiswa($mahasiswa)->withBerkas($berkas)->withBepe($bepe)->withBerkasumum($berkasumum);
          }
          else{
            return redirect('noaccess');
          }
      }


      public function registerBeasiswa(UploadRequest $request)
    {

        $beasiswa = DB::table('beasiswa')->orderBy('id_beasiswa', 'desc')->first();


       DB::insert('INSERT INTO `pendaftaran_beasiswa`(`id_beasiswa`, `id_mahasiswa`,`status_lamaran`,`alamat`,`nama_bank`,`nomor_rekening`,`jenis_identitas`,`nomor_identitas`,`nama_pemilik_rekening`,`nomor_telepon`,`nomor_hp`,`penghasilan_orang_tua`,`IPK` )
                  VALUES (?,?,1,?,?,?,?,?,?,?,?,?,?)',
                  [$request->get('idBeasiswa'),
                  $request->get('userid'),
                  $request->input('alamat'),
                  $request->input('namaBank'),
                  $request->input('norek'),
                  $request->input('jenisidentitas'),
                  $request->input('noidentitas'),
                  $request->input('namapemilik'),
                  $request->input('telp'),
                  $request->input('nohp'),
                  $request->input('penghasilan'),
                  $request->input('ipk')
                  ]
                );

       DB::insert('INSERT INTO `seleksi_beasiswa`(`id_beasiswa`, `id_penyeleksi`,`id_mahasiswa`,`id_tahapan`)
                  VALUES (?,?,?,?)',
                  [$request->get('idBeasiswa'),
                  $request->get('idPenyeleksi'),
                  $request->get('userid'),
                  $request->get('idTahapan')
                  ]
                );


                $id_pendaftaran = DB::table('pendaftaran_beasiswa')->orderBy('id_pendaftaran', 'desc')->first()->id_pendaftaran;
                $this->uploadSubmit($request, $id_pendaftaran);
      return redirect('/detail-beasiswa/'.$request->get('idBeasiswa'));
    }

    public function uploadSubmit(UploadRequest $request, int $id_pendaftaran)
    {
      $idBeasiswa = $request->get('idBeasiswa');
      $idMahasiswa = $request->get('userid');

      foreach ($request->berkases as $index=>$berkas) {
        $idBerkas = $request->idBerkas[$index];
        $file = $idMahasiswa.'-'.$request->nama[$index].'.pdf';
        $oldfile = DB::table('beasiswa_berkas')
                          ->where('id_pendaftaran', $id_pendaftaran)
                          ->where('id_beasiswa', $idBeasiswa)
                          ->where('id_berkas', $idBerkas)
                          ->where('id_mahasiswa', $idMahasiswa)
                          ->where('file', $file)
                          ->first();
        if ($oldfile == null) {
          DB::insert('INSERT INTO `beasiswa_berkas`(`id_pendaftaran`, `id_beasiswa`, `id_berkas`, `id_mahasiswa`, `file`)
                      VALUES (?,?,?,?,?)', [$id_pendaftaran, $idBeasiswa, $idBerkas, $idMahasiswa, $file]);
        }
        $berkas->storeAs('berkas', $file);
      }
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
    public function insertBeasiswa(Request $request)
    {
      DB::insert('INSERT INTO `beasiswa`(`nama_beasiswa`, `deskripsi_beasiswa`, `id_kategori`, `tanggal_buka`, `tanggal_tutup`,
                                        `kuota`, `nominal`, `dana`, `periode`,  `id_pendonor`, `jangka`, `id_status`, `public`, `flag`, `currency`, `id_jenis_seleksi`, `link_seleksi`)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,2,0,1,?,1,"")',
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
                  $request->input('jangka'),
                  $request->get('mataUang')
                ]
                );
      $beasiswa = DB::table('beasiswa')->orderBy('id_beasiswa', 'desc')->first();

      $arrSyarat = explode(",",$request->get('arraySyarat'));
      for($i = 0;$i < sizeof($arrSyarat);$i++)
      {
        DB::insert('insert into `persyaratan` (`id_beasiswa`, `syarat`) VALUES (?,?)', [$beasiswa->id_beasiswa, $request->input('syarat'.$arrSyarat[$i])]);
      }


      $request->get('listProdi');
      $hasil = explode(",",$request->get('listProdi'));
      $jenjang = $request->get('jenjangBeasiswa');
      for ($i = 0; $i < sizeof($hasil) ; $i++)
      {
        DB::insert('insert into `beasiswa_jenjang_prodi` (`id_beasiswa`, `id_jenjang`, `id_prodi`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, $jenjang, $hasil[$i]]);
        echo $hasil[$i];
      }

      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();

      DB::insert('insert into `log_beasiswa` (`id_beasiswa`, `tipe_perubahan`, `id_user`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, 'initial setup', $pengguna->username]);

      return redirect('/detail-beasiswa/'.$beasiswa->id_beasiswa);
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
          $idBeasiswa = $request->get('idBeasiswa');


          $user = SSO::getUser();
          $pengguna = DB::table('user')->where('username', $user->username)->first();

          DB::insert('insert into `log_beasiswa` (`id_beasiswa`, `tipe_perubahan`, `id_user`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, 'modifikasi', $pengguna->username]);

          return redirect('/detail-beasiswa/'.$idBeasiswa);
      }

    //   public function daftarBeasiswa($id)
    //   {
    //       $user = SSO::getUser();
    //       $pengguna = DB::table('user')->where('username', $user->username)->first();
    //       $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
    //       $namarole = $role->nama_role;

    //       // $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
    //       // $pendonor = DB::table('pendonor')->where('username', $user->username)->first();

    //       // if ($pengguna != null){
    //       // $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
    //       // $namarole = $role->nama_role_pegawai;
    //       // }
    //       // else if ($pendonor !=null)
    //       // {
    //       //   $entriPendonor = DB::table('user')->where('username', $pendonor->username)->first();
    //       //   $role = DB::table('role')->where('id_role', $entriPendonor->id_role)->first();
    //       //   $namarole = $role->nama_role;
    //       // }
    //       // else{
    //       //   return redirect('noaccess');
    //       // }
    //       //$kategoribeasiswa = DB::table('kategori_beasiswa')->get();
    //       // $pendonor = DB::table('pendonor')->get();
    //       // $jenjang = DB::table('jenjang')->get();
    //       // $fakultas = DB::table('fakultas')->get();
    //       $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
    //       if($namarole=='mahasiswa'){
    //         return view('pages.daftar-beasiswa')->withBeasiswa($beasiswa)->withUser($user)->withNamarole($namarole);
    //       }
    //       else{
    //         return redirect('noaccess');
    //       }



    //   }

    //   public function registerBeasiswa(Request $request)

    // {

    //   $beasiswa = DB::table('beasiswa')->orderBy('id_beasiswa', 'desc')->first();

    //   DB::insert('INSERT INTO `pendaftaran_beasiswa`(`id_beasiswa`, `npm_mahasiswa`)
    //               VALUES (?,?)',
    //               [$request->get('idBeasiswa'),
    //               $request->input('npm')]
    //             );

    //   return redirect('/detail-beasiswa/'.$request->get('idBeasiswa'));
    // }
}
