<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use SSO\SSO;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    function index()
    {
      if(!SSO::check()) {
        $user = null;
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
        return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user);
      }
      else{
        $user = SSO::getUser();
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='Pegawai'){
          $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role_pegawai;
        }

          $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
          return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole);
        }

    }

    function login()
    {
      if(!SSO::check())
        SSO::authenticate();
      $user = SSO::getUser();
      $exist = DB::table('user')->where('username', $user->username)->first();

      if ($exist == null)
      {
        if ($user->role != 'tamu')
          $email = $user->username."@ui.ac.id";
        else {
          $email = $user->username;
        }
        DB::insert('INSERT INTO `user`(`username`, `nama`, `email`, `id_role`)
                    VALUES (?,?,?,1)',
                    [
                        $user->username,
                        $user->name,
                        $email
                    ]
                  );
        $pgn = DB::table('user')->orderBy('id_user', 'desc')->first();

        if ($user->role == 'mahasiswa')
        {

          $ep = explode('(',$user->educational_program);
          $jenjang = DB::table('jenjang')->where('nama_jenjang', $ep)->first();

        $np = explode('(',$user->study_program);
        $namaprodi =ucwords(strtolower($np[0]));
        $prodi= DB::table('program_studi')->where('nama_prodi', $namaprodi)->first();

        if (count($prodi) == 0)
        {
          DB::insert('INSERT INTO `mahasiswa`(`id_user`, `npm`, `email`, `id_fakultas`,  `id_prodi`, `alamat`, `nama_bank`, `nomor_rekening`, `jenis_identitas`, `nomor_identitas`, `nama_pemilik_rekening`, `nomor_telepon`, `nomor_hp`, `penghasilan_orang_tua`, `IPK`)

                        VALUES (?,?,?,8,29,"Jalan Jambu No. 3","Mandiri", "1256134298","KTP", "121212121", ?, "021774499", "082112525123", "999999", "4.0")',
                      [
                          $pgn->id_user,
                          $user->npm,
                          $pgn->email,
                          $user->name
                      ]
                    );
        }
        // return $fakultas->id_fakultas;
        DB::insert('INSERT INTO `mahasiswa`(`id_user`, `npm`, `email`, `id_fakultas`, `id_prodi`, `id_jenjang`, `alamat`, `nama_bank`, `nomor_rekening`, `jenis_identitas`, `nomor_identitas`, `nama_pemilik_rekening`, `nomor_telepon`, `nomor_hp`, `penghasilan_orang_tua`, `IPK`)

        VALUES (?,?,?,?,?,?,"Jalan Jambu No. 3","Mandiri", "1256134298","KTP", "121212121", ?, "021774499", "082112525123", "999999", "4.0")',
        [
            $pgn->id_user,
            $user->npm,
            $pgn->email,
            $prodi->id_fakultas,
            $prodi->id_prodi,
            $jenjang->id_jenjang,
            $user->name
        ]
                  );
      }

    else {
      DB::insert('INSERT INTO `mahasiswa`(`id_user`, `npm`, `email`, `id_fakultas`,  `id_prodi`, `alamat`, `nama_bank`, `nomor_rekening`, `jenis_identitas`, `nomor_identitas`, `nama_pemilik_rekening`, `nomor_telepon`, `nomor_hp`, `penghasilan_orang_tua`, `IPK`)

                    VALUES (?,"1406623676",?,8,29,"Jalan Jambu No. 3","Mandiri", "1256134298","KTP", "121212121", ?, "021774499", "082112525123", "999999", "4.0")',
                  [
                      $pgn->id_user,

                      $pgn->email,
                      $user->name
                  ]
                );
    }
  }
        return redirect('');
    }

    function logout()
    {
      SSO::logout(URL::to('/'));
    }

    function listbeasiswa()
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='Pegawai'){
        $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
      }

      if ($namarole == 'Mahasiswa' || $namarole == 'Pegawai Fakultas') {
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->orderBy('beasiswa.id_beasiswa', 'desc')
        ->join('pendonor','pendonor.id_user', 'beasiswa.id_pendonor')
        ->join('log_beasiswa','beasiswa.id_beasiswa', '=', 'log_beasiswa.id_beasiswa')->where('tipe_perubahan', 'initial setup')
        ->get();

      } else if ($namarole == 'Pendonor'){
        $pendonor = DB::table('pendonor')->where('id_user', $pengguna->id_user)->first();
        $beasiswas = collect(DB::table('beasiswa')->where('flag', '1')->where('public', '1')->orderBy('beasiswa.id_beasiswa', 'desc')
        ->join('pendonor','pendonor.id_user', 'beasiswa.id_pendonor')
        ->join('log_beasiswa','beasiswa.id_beasiswa', '=', 'log_beasiswa.id_beasiswa')->get());

        $beasiswas2= collect(DB::table('beasiswa')->where('flag', '1')->where('public', '0')->where('beasiswa.id_pendonor', $pendonor->id_user)
        ->join('pendonor','pendonor.id_user', 'beasiswa.id_pendonor')
        ->join('log_beasiswa','beasiswa.id_beasiswa', '=', 'log_beasiswa.id_beasiswa')
        ->orderBy('beasiswa.id_beasiswa', 'desc')->get());
        
        $beasiswas = $beasiswas->merge($beasiswas2)->sort()->values()->all();

      } else {
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->orderBy('beasiswa.id_beasiswa', 'desc')
        ->leftJoin('dokumen_kerjasama','beasiswa.id_beasiswa', '=', 'dokumen_kerjasama.id_beasiswa')
        ->join('pendonor','pendonor.id_user', 'beasiswa.id_pendonor')
        ->join('log_beasiswa','beasiswa.id_beasiswa', '=', 'log_beasiswa.id_beasiswa')
        ->where('tipe_perubahan', 'initial setup')
        ->get();
      }

      $daftarBeasiswa = DB::table('beasiswa_penyeleksi')->where('id_penyeleksi', $pengguna->id_user)
												->join('beasiswa','beasiswa_penyeleksi.id_beasiswa', 'beasiswa.id_beasiswa')
												->select('beasiswa.id_beasiswa', 'beasiswa.nama_beasiswa')->orderBy('id_beasiswa', 'desc')->get();

      $dokumenkerjasama = DB::table('dokumen_kerjasama')->get();

			$seleksichecker = 0;
			if ($daftarBeasiswa->count() == 0)
			{
				return view('pages.list-beasiswa')->withDokumenkerjasamas($dokumenkerjasama)->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole)->withSeleksichecker($seleksichecker);
			}
			else{
				$seleksichecker = 1;
        return view('pages.list-beasiswa')->withDokumenkerjasamas($dokumenkerjasama)->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole)->withSeleksichecker($seleksichecker);
			}

    }
     function addbeasiswa()
    {
      $user = SSO::getUser();

      $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();

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
    function noaccess()
    {
      if(!SSO::check()) {
        $user = null;
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
        return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user);
      }
      else{
        $user = SSO::getUser();
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='Pegawai'){
          $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role_pegawai;
        }

          $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get();
          return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
        }

    }

    function sudahDaftar()
    {
      if(!SSO::check()) {
        $user = null;
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->take(4)->get();
        return view('pages.homepage')->withBeasiswas($beasiswas)->withUser($user);
      }
      else{
        $user = SSO::getUser();
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='Pegawai'){
          $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role_pegawai;
        }
          $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get();
          return view('pages.sudah-mendaftar')->withUser($user)->withNamarole($namarole);
        }
    }

    function detailbeasiswa($id)
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='Pegawai'){
        $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
      }

      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      $kategori = DB::table('kategori_beasiswa')->where('id_kategori', $beasiswa->id_kategori)->first();
      $persyaratans = DB::table('persyaratan')->where('id_beasiswa', $beasiswa->id_beasiswa)->get();

      $retrIsPenyeleksi = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $beasiswa->id_beasiswa)->where('id_penyeleksi', $pengguna->id_user)->first();
      $isPenyeleksi = 1;
      if (empty($retrIsPenyeleksi))
        {$isPenyeleksi = 0;}


      //Dengan asumsi bahwa setiap beasiswa pasti ada yang diterima
      $retrIsSelected = DB::table('penerima_beasiswa')->where('id_beasiswa', $beasiswa->id_beasiswa)->first();
      $isSelected = 1;
      if (empty($retrIsSelected))
        {$isSelected = 0;}



      if ($namarole=='Pendonor')
      {
        $isPendonor = false;
        $pendonor = DB::table('beasiswa')
                    ->where('id_beasiswa', $beasiswa->id_beasiswa)
                    ->join('pendonor', 'beasiswa.id_pendonor', '=', 'pendonor.id_user')
                    ->select('pendonor.*')
                    ->first();
        if ($pendonor->id_user == $pengguna->id_user)
        {
          $isPendonor = true;
        }

        $pendaftars = DB::table('pendaftaran_beasiswa')
                    ->where('id_beasiswa', $beasiswa->id_beasiswa)
                    ->join('user', 'pendaftaran_beasiswa.id_mahasiswa', '=', 'user.id_user')
                    ->select('pendaftaran_beasiswa.*', 'user.nama')
                    ->get();

        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole)->withPendaftars($pendaftars)->withIspendonor($isPendonor)->withKategori($kategori)->withIspenyeleksi($isPenyeleksi)->withIsselected($isSelected);
      }
      else
      {
        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole)->withKategori($kategori)->withIspenyeleksi($isPenyeleksi)->withIsselected($isSelected);
      }
    }

   function profil()
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('user')->where('id_user', $pengguna->id_user)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

          if($namarole=='Pendonor')
          {
            $nama = DB::table('user')->where('username',$user->username)->first();
            $pendonor = DB::table('pendonor')->where('id_user', $nama->id_user)->first();
          /*  $instansi = DB::table('pendonor')->where('id_pendonor', $pendonor->id_pendonor)->first();
            $namaInstansi = $instansi->nama_instansi;*/

            /* $profil = DB::table('pendonor')->where('id_pendonor', $id)->first();
             $jabatans = DB::table('pegawai')->where('jabatan', $jabatan->id_role_pegawai)->get();*/

          $beasiswas = DB::table('beasiswa')->where('id_pendonor',$pendonor->id_user)->get();


            return view('pages.profil')->withNama($nama)
            ->withPengguna($pengguna)
            ->withPendonor($pendonor)
            ->withUser($user)
            ->withNamarole($namarole)->withBeasiswas($beasiswas);
          }


          else if($namarole=='Mahasiswa')
          {

              $nama = DB::table('user')->where('username', $user->username)->first();
              $mahasiswa = DB::table('mahasiswa')->where('id_user',$nama->id_user)->first();
            /* $idmahasiswa = DB::table('user')->where('id_user', $user->id_user)->first();*/
             $fakultas = DB::table('fakultas')->where('id_fakultas',$mahasiswa->id_fakultas)->first();
             $prodi = DB::table('program_studi')->where('id_prodi',$mahasiswa->id_prodi)->first();
             $jenjang = DB::table('jenjang_prodi')->where('id_prodi',$mahasiswa->id_prodi)->first();
             $jenjangMahasiswa = DB::table('jenjang')->where('id_jenjang',$jenjang->id_jenjang)->first();

              $beasiswas = DB::table('pendaftaran_beasiswa')->where('id_mahasiswa',$mahasiswa->id_user)
            ->join('beasiswa','beasiswa.id_beasiswa', '=', 'pendaftaran_beasiswa.id_beasiswa')
            ->join('status_lamaran', 'status_lamaran.id_status_lamaran',"=", 'pendaftaran_beasiswa.status_lamaran')
            ->select('beasiswa.*','status_lamaran.nama_lamaran','pendaftaran_beasiswa.waktu_melamar')
            ->get();

            $berkas = DB::table('berkas_umum')
                              ->where('id_mahasiswa', $pengguna->id_user)
                              ->join('berkas', 'berkas.id_berkas', '=', 'berkas_umum.id_berkas')
                              ->select('berkas_umum.*', 'berkas.nama_berkas')
                              ->get();

            return view('pages.profil')->withPengguna($pengguna)->withNama($nama)->withUser($user)->withMahasiswa($mahasiswa)->withNamarole($namarole)->withBeasiswas($beasiswas)->withFakultas($fakultas)->withProdi($prodi)->withJenjangmahasiswa($jenjangMahasiswa)->withBerkas($berkas);
            /*$mahasiswa = DB::table('mahasiswa')->where('username',$user->username)->first();

            $fakultas = DB::table('fakultas')->where('id_fakultas',$mahasiswa->id_fakultas)->first();
            $prodi = DB::table('program_studi')->where('id_prodi',$mahasiswa->id_prodi)->first();
            $beasiswas = DB::table('pendaftaran_beasiswa')->where('npm_mahasiswa',$mahasiswa->npm)
            ->join('beasiswa','beasiswa.id_beasiswa', '=', 'pendaftaran_beasiswa.id_beasiswa')
            ->select('beasiswa.*')
            ->get();

            return view('pages.profil')->withPengguna($pengguna)->withUser($user)->withMahasiswa($mahasiswa)->withNamarole($namarole)->withBeasiswas($beasiswas)->withFakultas($fakultas)->withProdi($prodi);*/
          }

          else if($namarole=='Pegawai')
          {
           $nama = DB::table('user')->where('username', $user->username)->first();
           $pegawai = DB::table('pegawai')->where('id_user',$nama->id_user)->first();
         /* $pegawai = DB::table('pegawai')->where('username',$user->username)->first();*/
          $role_pegawai = DB::table('role_pegawai')->where('id_role_pegawai', $pegawai->id_role_pegawai)->first();
          $namarole = $role_pegawai->nama_role_pegawai;
          $jabatan = DB::table('jabatan')->where('id_jabatan', $pegawai->id_jabatan)->first();

          return view('pages.profil')->withPengguna($pengguna)->withUser($user)->withPegawai($pegawai)->withNamarole($namarole)->withNama($nama)->withJabatan($jabatan);
          }
    }

     function editProfil()
    {
            $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('user')->where('id_user', $pengguna->id_user)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

          if($namarole=='Pendonor')
          {
            $nama = DB::table('user')->where('username',$user->username)->first();
            $pendonor = DB::table('pendonor')->where('id_user', $nama->id_user)->first();

          $beasiswas = DB::table('beasiswa')->where('id_pendonor',$pendonor->id_user)->get();


            return view('pages.profil')->withNama($nama)
            ->withPengguna($pengguna)
            ->withPendonor($pendonor)
            ->withUser($user)
            ->withNamarole($namarole)->withBeasiswas($beasiswas);
          }


          else if($namarole=='Mahasiswa')
          {

              $nama = DB::table('user')->where('username', $user->username)->first();
              $mahasiswa = DB::table('mahasiswa')->where('id_user',$nama->id_user)->first();

             $fakultas = DB::table('fakultas')->where('id_fakultas',$mahasiswa->id_fakultas)->first();
             $prodi = DB::table('program_studi')->where('id_prodi',$mahasiswa->id_prodi)->first();
              $jenjang = DB::table('jenjang_prodi')->where('id_prodi',$mahasiswa->id_prodi)->first();
             $jenjangMahasiswa = DB::table('jenjang')->where('id_jenjang',$jenjang->id_jenjang)->first();

              $beasiswas = DB::table('pendaftaran_beasiswa')->where('id_mahasiswa',$mahasiswa->id_user)
            ->join('beasiswa','beasiswa.id_beasiswa', '=', 'pendaftaran_beasiswa.id_beasiswa')
            ->select('beasiswa.*')
            ->get();


            return view('pages.edit-profil')->withPengguna($pengguna)->withNama($nama)->withUser($user)->withMahasiswa($mahasiswa)->withNamarole($namarole)->withBeasiswas($beasiswas)->withFakultas($fakultas)->withProdi($prodi)->withJenjangmahasiswa($jenjangMahasiswa);

          }

          else if($namarole=='Pegawai')
          {
           $nama = DB::table('user')->where('username', $user->username)->first();
           $pegawai = DB::table('pegawai')->where('id_user',$nama->id_user)->first();
         /* $pegawai = DB::table('pegawai')->where('username',$user->username)->first();*/
          $role_pegawai = DB::table('role_pegawai')->where('id_role_pegawai', $pegawai->id_role_pegawai)->first();
          $namarole = $role_pegawai->nama_role_pegawai;
          $jabatan = DB::table('jabatan')->where('id_jabatan', $pegawai->id_jabatan)->first();

          return view('pages.profil')->withPengguna($pengguna)->withUser($user)->withPegawai($pegawai)->withNamarole($namarole)->withNama($nama)->withJabatan($jabatan);
          }
    }

 function updateProfil(Request $request)
{
   DB::table('mahasiswa')
          ->where('id_user', $request->get('idUser'))
          ->update(['jenis_identitas'=>$request->input('jenisIdentitas'),
                    'nomor_identitas'=>$request->input('nomorIdentitas'),
                    'nama_pemilik_rekening'=>$request->input('pemilikRekening'),
                    'nama_bank'=>$request->input('namaBank'),
                    'nomor_rekening'=>$request->input('nomorRekening'),
                    'nomor_telepon'=>$request->input('nomorTelepon'),
                    'nomor_hp'=>$request->input('nomorHandphone')
                  ]);
          $idUser = $request->get('idUser');


          $user = SSO::getUser();
          $pengguna = DB::table('user')->where('username', $user->username)->first();

        // DB::insert('insert into `log_beasiswa` (`id_beasiswa`, `tipe_perubahan`, `id_user`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, 'modifikasi', $pengguna->username]);

          return redirect('profil');
}

function pendaftarBeasiswa($id)
    {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('user')->where('id_user', $pengguna->id_user)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;
      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      $penyeleksi = DB::table('beasiswa_penyeleksi')->where('id_penyeleksi', $pengguna->id_user)->first();


          if( $namarole=='Pendonor' && $pengguna->id_user == $beasiswa->id_pendonor )
          {
            $mahasiswas = DB::table('pendaftaran_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)
            ->join('mahasiswa','mahasiswa.id_user', '=', 'pendaftaran_beasiswa.id_mahasiswa')
            ->join('user', 'user.id_user', '=', 'pendaftaran_beasiswa.id_mahasiswa')
            ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->select('mahasiswa.*','user.nama', 'fakultas.nama_fakultas', 'program_studi.nama_prodi')
            ->get();



            return view('pages.pendaftar-beasiswa')
            ->withPengguna($pengguna)
            ->withUser($user)
            ->withNamarole($namarole)->withBeasiswa($beasiswa)->withMahasiswas($mahasiswas);
          }
          else if ($namarole == 'Pegawai')
          {
            if($penyeleksi->id_penyeleksi == $pengguna->id_user)
            {
              $mahasiswas = DB::table('pendaftaran_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)
            ->join('mahasiswa','mahasiswa.id_user', '=', 'pendaftaran_beasiswa.id_mahasiswa')
            ->join('user', 'user.id_user', '=', 'pendaftaran_beasiswa.id_mahasiswa')
            ->join('fakultas', 'fakultas.id_fakultas', '=', 'mahasiswa.id_fakultas')
            ->join('program_studi', 'program_studi.id_prodi', '=', 'mahasiswa.id_prodi')
            ->select('mahasiswa.*','user.nama', 'fakultas.nama_fakultas', 'program_studi.nama_prodi')
            ->get();



            return view('pages.pendaftar-beasiswa')
            ->withPengguna($pengguna)
            ->withUser($user)
            ->withNamarole($namarole)->withBeasiswa($beasiswa)->withMahasiswas($mahasiswas);
            }

          }


          else
          {
            return redirect('noaccess');
          }
    }


  function lihatBerkas($idbeasiswa,$iduser)
  {
    $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $pengguna = DB::table('user')->where('id_user', $pengguna->id_user)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      $mahasiswa = DB::table('mahasiswa')->where('id_user', $iduser)->first();
      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $idbeasiswa)->first();

          if($namarole=='Pendonor')
          {
            $berkas = DB::table('beasiswa_berkas')->where('beasiswa_berkas.id_mahasiswa', $mahasiswa->id_user)->where('beasiswa_berkas.id_beasiswa', $beasiswa->id_beasiswa)
            ->join('mahasiswa','mahasiswa.id_user', '=', 'beasiswa_berkas.id_mahasiswa')
            ->join('beasiswa', 'beasiswa.id_beasiswa', '=', 'beasiswa_berkas.id_beasiswa')
            ->join('berkas', 'berkas.id_berkas', '=', 'beasiswa_berkas.id_berkas')
            ->join('pendaftaran_beasiswa', 'pendaftaran_beasiswa.id_pendaftaran', '=', 'beasiswa_berkas.id_pendaftaran')
            ->select('mahasiswa.*','beasiswa_berkas.*','berkas.nama_berkas', 'pendaftaran_beasiswa.id_pendaftaran')
            ->get();

            $namaMhs = DB::table('user')->where('id_user', $iduser)->first();
            $fakultas = DB::table('fakultas')->where('id_fakultas', $mahasiswa->id_fakultas)->first();
            $prodi = DB::table('program_studi')->where('id_prodi', $mahasiswa->id_prodi)->first();

            return view('pages.lihat-berkas-mahasiswa', compact('beasiswa','pengguna','user','namarole','mahasiswa','namaMhs','berkas','fakultas','prodi'));
          }
          else if($namarole=='Pegawai')
          {
            $berkas = DB::table('beasiswa_berkas')->where('beasiswa_berkas.id_mahasiswa', $mahasiswa->id_user)->where('beasiswa_berkas.id_beasiswa', $beasiswa->id_beasiswa)
            ->join('mahasiswa','mahasiswa.id_user', '=', 'beasiswa_berkas.id_mahasiswa')
            ->join('beasiswa', 'beasiswa.id_beasiswa', '=', 'beasiswa_berkas.id_beasiswa')
            ->join('berkas', 'berkas.id_berkas', '=', 'beasiswa_berkas.id_berkas')
            ->join('pendaftaran_beasiswa', 'pendaftaran_beasiswa.id_pendaftaran', '=', 'beasiswa_berkas.id_pendaftaran')
            ->select('mahasiswa.*','beasiswa_berkas.*','berkas.nama_berkas', 'pendaftaran_beasiswa.id_pendaftaran')
            ->get();

            $namaMhs = DB::table('user')->where('id_user', $iduser)->first();
            $fakultas = DB::table('fakultas')->where('id_fakultas', $mahasiswa->id_fakultas)->first();
            $prodi = DB::table('program_studi')->where('id_prodi', $mahasiswa->id_prodi)->first();


            return view('pages.lihat-berkas-mahasiswa', compact('beasiswa','pengguna','user','namarole','mahasiswa','namaMhs','berkas','fakultas','prodi'));
          }


          else
          {
            return redirect('noaccess');
          }

  }


  function download(Request $request)
  {
      $user = SSO::getUser();
      return response()->download(storage_path('app/berkas/'.$user->username.'/'.$request->berkas));
  }

  function unduhDK(Request $request)
  {
      return response()->download(storage_path('app/dokumen_kerjasama/'.$request->idBeasiswa.'/'.$request->dk));
  }

  function pageSeleksi(){
			// get seleksi
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if($namarole=='pegawai'){
				$pengguna = DB::table('pegawai')->where('username', $user->username)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}



			$daftarBeasiswa = DB::table('beasiswa_penyeleksi')->where('id_penyeleksi', $pengguna->id_user)
												->join('beasiswa','beasiswa_penyeleksi.id_beasiswa', '=','beasiswa.id_beasiswa')->where('public', '1')->where('flag','1')
												->select('beasiswa.id_beasiswa', 'beasiswa.nama_beasiswa', 'beasiswa.id_jenis_seleksi')->distinct()->orderBy('id_jenis_seleksi','desc')->get();

			$b = [];
			foreach ($daftarBeasiswa as $key=>$beasiswa)
			{
				 $a = DB::table('pendaftaran_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)->count();
				 array_push($b, $a);
				//	echo $beasiswa->id_beasiswa.'asd'.$a;
			}

			if ($daftarBeasiswa->count() == 0)
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}
			else{
			return view('pages.daftar-seleksi')->withDaftarbeasiswa($daftarBeasiswa)->withUser($user)->withNamarole($namarole)->withJumlahpendaftar($b);
			}
		}



		function seleksi($id)
		{
			/*
				Cek if user adalah penyeleksi beasiswa
				Jika iya, tunjukkan page seleksi beasiswa beserta tahapannya tapi di disabled kalau dia bukan penyeleksi tahapan tsb
				Jika dia penyeleksi tahapan tsb. tunjukkan tombol lakukan seleksiBeasiswa
				Jika tidak, tunjukkan no acces

				------------------------------------------SELEKSI
			*/
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if ($namarole=='Mahasiswa')
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}

			//Retrieve role pegawai
			else if($namarole=='Pegawai'){
				$pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}

			//Cek if user adalah penyeleksi untuk beasiswa tersebut
			$retrievePenyeleksi = DB::table('beasiswa_penyeleksi')->where('id_beasiswa',$id)->where('id_penyeleksi', $pengguna->id_user)->first();


			if (empty($retrievePenyeleksi))
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}
			else{

				//Retrieve Akses Beasiswa: didapat dari get semua bp dgn beasiswa dan penyeleksi tertentu

				$retrAksesTahapan = DB::table('beasiswa_penyeleksi')->where('id_beasiswa',$id)->where('id_penyeleksi', $pengguna->id_user)
				->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
				->select('beasiswa_penyeleksi_tahapan.id_tahapan')->get();

				//Retrieve Tahapan Beasiswa: tahapan yang ada dari sebuah beasiswa
				$retrTahapan = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $id)
				->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
				->join('tahapan','beasiswa_penyeleksi_tahapan.id_tahapan','=','tahapan.id_tahapan')
				->join('user','beasiswa_penyeleksi.id_penyeleksi','=','user.id_user')
				->select('beasiswa_penyeleksi_tahapan.id_tahapan', 'tahapan.nama_tahapan','user.nama')
				->orderBy('beasiswa_penyeleksi_tahapan.id_bpt', 'asc')->get();

				$b=[];
        $check = 0;
				foreach($retrTahapan as $key=>$tahapan)
				{
					$a = DB::table('seleksi_beasiswa')->where('id_beasiswa',$id)->where('id_tahapan', $tahapan->id_tahapan)->where('final', '0')->count();
					array_push($b, $a);

					if (count($retrTahapan)-1 == $key)
					{
						$final = DB::table('seleksi_beasiswa')->where('id_beasiswa', $id)->where('id_tahapan',$tahapan->id_tahapan)->first();

            if (empty($final))
            {
              $check = 0;
            }
            else if ($final->final == 1)
						{
							$check = 1;
						}
						else{
							$check=0;
						}
					}
				}

				$beasiswa= DB::table('beasiswa')->where('id_beasiswa', $id)->first();
				return view('pages.seleksi-beasiswa')->withUser($user)->withNamarole($namarole)->withAksestahapan($retrAksesTahapan)->withTahapan($retrTahapan)->withIdbeasiswa($id)->withBeasiswa($beasiswa)->withJumlahpartisipan($b)->withCheck($check);


			}
		}

		function seleksiLuar($idBeasiswa)
		{
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;
      $tahapanljt = 0;
			if ($namarole=='Mahasiswa')
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}

			//Retrieve role pegawai
			else if($namarole=='Pegawai'){
				$pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}

			$idTahapan = '5';

			//Cek apakah penyeleksi mwmiliki akses ke tahapan
			$cekPenyeleksi = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $idBeasiswa)->where('id_penyeleksi', $pengguna->id_user)
			->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
			->where('id_tahapan',$idTahapan)->get();

			//Kalau tidak punya akses, maka di redirect ke page noaccess
			if ($cekPenyeleksi->count() == 0)
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}
			//Kalau punya akses:
			else{
					$beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
          //cek tahapan lanjut


        	// Cek apakah sudah final atau belum
					$final = 0;

					/*	final = 1 -> belum ada pendaftar
					*		final = 2 -> lihat hasil
					*/
					$cekFinal = DB::table('seleksi_beasiswa')->where('id_beasiswa', $idBeasiswa)->where('id_tahapan', '5')->first();
					$tahapan = DB::table('tahapan')->where('id_tahapan',$idTahapan)->first();
          $penerimaChecker = 0;
					if (empty($cekFinal)) // Jika belum/ tidak ada pendaftar
					{
						$final = 1;
						return view('pages.seleksi-tahapan')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final)->withTahapan($tahapan)->withPenerimachecker($penerimaChecker)->withTahapanljt($tahapanljt);
					}
					else{
						$pendaftar = DB::table('seleksi_beasiswa')->where('id_beasiswa', $idBeasiswa)
						->where('id_tahapan',$idTahapan)
						->join('user','seleksi_beasiswa.id_mahasiswa','=','user.id_user')
						->select('seleksi_beasiswa.id_mahasiswa', 'seleksi_beasiswa.nilai_seleksi', 'seleksi_beasiswa.final', 'user.nama')->get();

						if($cekFinal -> final == '1')
						{
							$final = 2;
              $penerimaChecker = 1;
							return view('pages.seleksi-luar')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withPendaftar($pendaftar)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final)->withTahapan($tahapan)->withPenerimachecker($penerimaChecker)->withTahapanljt($tahapanljt);
						}
						else{
							return view('pages.seleksi-luar')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withPendaftar($pendaftar)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final)->withTahapan($tahapan)->withPenerimachecker($penerimaChecker)->withTahapanljt($tahapanljt);
						}

					}
			}

		}

		function seleksiBeasiswa($idBeasiswa, $idTahapan){
			$user = SSO::getUser();
			$pengguna = DB::table('user')->where('username', $user->username)->first();
			$role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
			$namarole = $role->nama_role;

			if ($namarole=='Mahasiswa')
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}

			//Retrieve role pegawai
			else if($namarole=='Pegawai'){
				$pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
				$role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
				$namarole = $role->nama_role_pegawai;
			}

			//Check apakah penyeleksi ini memiliki akses ke tahapan tertentu dari beasiswa tertentu
			$cekPenyeleksi = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $idBeasiswa)->where('id_penyeleksi', $pengguna->id_user)
			->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
			->where('id_tahapan',$idTahapan)->get();

			if ($cekPenyeleksi->count() == 0)
			{
				return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
			}
			else{
				// Cek if tahapan ini udah final atau belum, kalau udah final cuma bisa lihat hasil seleksi
				//get nama dan nilai pendaftar beasiswa untuk tahap ini

				$beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
        $penerimaChecker = DB::table('penerima_beasiswa')->where('id_beasiswa', $idBeasiswa)->first();
        if (empty($penerimaChecker))
        {
          $penerimaChecker = 0;
        }
        else{
          $penerimaChecker = 1;
        }
        $tahapanljt = 0; // 0 -> ini adalah tahap terakhir
        $namaljt = '';
        $penyeleksiljt = 0; // 0 -> pengguna sekarang bukan penyeleksi tahap berikutnya; 1 -> pengguna sekarang adl penyelksi tahap berikutnya
        $daftarTahapan = DB::table('beasiswa_penyeleksi')->join('beasiswa_penyeleksi_tahapan', 'beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
                        ->where('beasiswa_penyeleksi.id_beasiswa', $idBeasiswa)->get();
        $setTmp = 0;
        foreach($daftarTahapan as $key=>$dt)
        {
          if ($setTmp == 1)
          {
            $tahapanljt = $dt->id_tahapan;
            $namaljt = DB::table('tahapan')->where('id_tahapan', $tahapanljt)->first();
            if ($dt->id_penyeleksi == $pengguna->id_user)
            {
              $penyeleksiljt = 1;
            }
            break;
          }
          if ($dt->id_tahapan == $idTahapan)
          {
            $setTmp = 1;
          }

        }

        if ($penerimaChecker == 1)
        {
          $penerima = DB::table('penerima_beasiswa')->where('id_beasiswa', $idBeasiswa)->get();
        }
        else{
          $penerima = '';
        }
        // foreach ($penerima as $penerima)
        // {
        //   return $penerima->id_beasiswa;
        // }
        // return $penerima->id_beasiswa;
				$final = 0;
				/*	final = 1 -> belum ada pendaftar
				*		final = 2 -> lihat hasi
				*/
				$cekFinal = DB::table('seleksi_beasiswa')->where('id_beasiswa', $idBeasiswa)->where('id_tahapan', $idTahapan)->first();
				$tahapan = DB::table('tahapan')->where('id_tahapan', $idTahapan)->first();
				if (empty($cekFinal)) // Jika belum/ tidak ada pendaftar
				{
					$final = 1;
					return view('pages.seleksi-tahapan')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final)->withTahapan($tahapan)->withTahapanljt($tahapanljt)->withPenyeleksiljt($penyeleksiljt)->withNamaljt($namaljt)->withPenerimachecker($penerimaChecker)->withPenerima($penerima);
				}
				else{
					$pendaftar = DB::table('seleksi_beasiswa')->where('id_beasiswa', $idBeasiswa)
					->where('id_tahapan','=',$idTahapan)
					->join('user','seleksi_beasiswa.id_mahasiswa','=','user.id_user')
					->select('seleksi_beasiswa.id_mahasiswa', 'seleksi_beasiswa.nilai_seleksi', 'seleksi_beasiswa.final', 'user.nama')->get();

					if($cekFinal -> final == '1')
					{
						$final = 2;
						return view('pages.seleksi-tahapan')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withPendaftar($pendaftar)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final)->withTahapan($tahapan)->withTahapanljt($tahapanljt)->withPenyeleksiljt($penyeleksiljt)->withNamaljt($namaljt)->withPenerimachecker($penerimaChecker)->withPenerima($penerima);
					}
					else{
						return view('pages.seleksi-tahapan')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withPendaftar($pendaftar)->withIdtahapan($idTahapan)->withIdbeasiswa($idBeasiswa)->withBeasiswa($beasiswa)->withFinal($final)->withTahapan($tahapan)->withTahapanljt($tahapanljt)->withPenyeleksiljt($penyeleksiljt)->withNamaljt($namaljt)->withPenerimachecker($penerimaChecker)->withPenerima($penerima);
					}

				}
			}

		}
		function savedraftest(Request $request)
		{

      // get partisipan seleksi beasiswa untuk tahapan ini
      $partisipan = DB::table('seleksi_beasiswa')->where('id_beasiswa', $request->idbeasiswa)->where('id_tahapan', $request->idtahapan)->select('id_mahasiswa')->get();
      //get nama tahapan
      $namatahapan = DB::table('tahapan')->where('id_tahapan', $request->idtahapan)->select('nama_tahapan')->first();

      if ($namatahapan->nama_tahapan == 'Seleksi Administratif')
      {
        $idstatus = 2;
      }
      else if ($namatahapan->nama_tahapan == 'Seleksi Berkas')
      {
        $idstatus = 3;
      }
      else if ($namatahapan->nama_tahapan == 'Tes Tertulis')
      {
        $idstatus = 4;
      }
      else if ($namatahapan->nama_tahapan == 'Wawancara')
      {
        $idstatus = 5;
      }


      foreach($partisipan as $key => $partisipan)
      {
        DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $partisipan->id_mahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => '7']);
      }
      foreach ($request->table as $key => $idMahasiswa) {
          DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => $idstatus]);
      }

      /*
        Jika ada tahapan berikutnya, maka masukkan nama finalis ke db untuk tahap berikutnya
      */
      $retrTahapan = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $request->idbeasiswa)
      ->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
      ->join('tahapan','beasiswa_penyeleksi_tahapan.id_tahapan','=','tahapan.id_tahapan')
      ->join('user','beasiswa_penyeleksi.id_penyeleksi','=','user.id_user')
      ->select('beasiswa_penyeleksi_tahapan.id_tahapan', 'tahapan.nama_tahapan','beasiswa_penyeleksi.id_penyeleksi')
      ->orderBy('beasiswa_penyeleksi_tahapan.id_bpt', 'asc')->get();
      $set=0;

      foreach ($retrTahapan as $key => $tahapan) {
        if (count($retrTahapan)-1 == $key)
        {
          DB::table('seleksi_beasiswa')
          ->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
          ->where('id_tahapan', $request->idtahapan)
          ->update(['final' => '1']);
          foreach ($request->table as $key => $idMahasiswa) {
              DB::table('penerima_beasiswa')->insert(
                ['id_beasiswa' => $request->idbeasiswa,
                'id_mahasiswa'=>$idMahasiswa
              ]
            );
            DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => '6']);
          }
        }
        if ($set==1)
        {
          $set=$tahapan->id_tahapan;
          $idpenyeleksi = DB::table('beasiswa_penyeleksi_tahapan')->join('beasiswa_penyeleksi', 'beasiswa_penyeleksi.id_bp', '=', 'beasiswa_penyeleksi_tahapan.id_bp')
                          ->where('id_beasiswa',$request->idbeasiswa)->where('id_tahapan',$set)->first();
          DB::table('seleksi_beasiswa')
          ->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
          ->where('id_tahapan', $request->idtahapan)
          ->update(['final' => '1']);
          foreach ($request->table as $key => $idMahasiswa) {
              DB::table('seleksi_beasiswa')->insert(
                ['id_beasiswa' => $request->idbeasiswa,
                'id_penyeleksi'=>$idpenyeleksi->id_penyeleksi,
                'id_tahapan'=>$set,
                'id_mahasiswa'=>$idMahasiswa
              ]
            );
          }
          break;
        }
        else if ($tahapan->id_tahapan == $request->idtahapan)
        {
          $set=1;
        }
      }

      return response()->json(array('msg'=> $set), 200);
		}

		function saveDraftCheck(Request $request)
		{
			//Loop untuk setiap partisipan yang namanya ada di dalam table
      DB::table('seleksi_beasiswa')->where('id_beasiswa', $request->idbeasiswa)->where('id_tahapan', $request->idtahapan)
      ->where('id_penyeleksi', $request->pengguna)->update(['nilai_seleksi' =>'0']);

      foreach ($request->table as $key => $idMahasiswa) {
				DB::table('seleksi_beasiswa')->where('id_beasiswa',$request->idbeasiswa)->where('id_tahapan', $request->idtahapan)
				->where('id_mahasiswa', $idMahasiswa)->where('id_penyeleksi', $request->pengguna)->update(['nilai_seleksi' =>'1']);
			}
			  return response()->json(array('msg'=> $request->table), 200);
		}






		function sort($a,$b)
		{
			return ($a[1] >= $b[1]) ? -1 : 1;
		}



		function saveDraft(Request $request)
		{

			$table = explode("&",$request->get('table'));

			for($i = 0;$i < sizeof($table);$i++)
			{
				$row = explode("=",$table[$i]);
				DB::table('seleksi_beasiswa')
				->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
				->where('id_tahapan', $request->idtahapan)->where('id_mahasiswa', $row[0])
				->update(['nilai_seleksi' => $row[1]]);
			}
			$return_2d_array = array_map (
			function ($_) {return explode ('=', $_);},
			explode ('&', $request->get('table'))
			);
			usort($return_2d_array, array($this,'sort'));
			//$msg = "This is a simple message.";
			return response()->json(array('msg'=> $return_2d_array), 200);
		}

    function retrieveNama(Request $request)
    {
      $nama=DB::table('user')->where('id_user', $request->id_user)->select('nama')->first();
      return response()->json(array('msg'=> $nama), 200);
    }

		function finalizeResultChecked(Request $request)
		{
			$partisipan = DB::table('seleksi_beasiswa')->where('id_beasiswa', $request->idbeasiswa)->where('id_tahapan', $request->idtahapan)->select('id_mahasiswa')->get();
			foreach($partisipan as $key => $partisipan)
			{
				DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $partisipan->id_mahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => '7']);
			}



			DB::table('seleksi_beasiswa')->where('id_beasiswa',$request->idbeasiswa)->where('id_tahapan', $request->idtahapan)
			->where('id_penyeleksi', $request->pengguna)->update(['final'=>'1']);

			foreach ($request->table as $key => $idMahasiswa) {
				DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => '6']);
				DB::table('penerima_beasiswa')->insert(
					['id_beasiswa' => $request->idbeasiswa,
					'id_mahasiswa'=>$idMahasiswa
				]
			);

			}
			$msg = 'success';
			return response()->json(array('msg'=> $msg), 200);
		}

		function finalizeResult(Request $request)
		{

			// get partisipan seleksi beasiswa untuk tahapan ini
			$partisipan = DB::table('seleksi_beasiswa')->where('id_beasiswa', $request->idbeasiswa)->where('id_tahapan', $request->idtahapan)->select('id_mahasiswa')->get();
			//get nama tahapan
			$namatahapan = DB::table('tahapan')->where('id_tahapan', $request->idtahapan)->select('nama_tahapan')->first();

			if ($namatahapan->nama_tahapan == 'Seleksi Administratif')
			{
				$idstatus = 2;
			}
			else if ($namatahapan->nama_tahapan == 'Seleksi Berkas')
			{
				$idstatus = 3;
			}
			else if ($namatahapan->nama_tahapan == 'Tes Tertulis')
			{
				$idstatus = 4;
			}
			else if ($namatahapan->nama_tahapan == 'Wawancara')
			{
				$idstatus = 5;
			}


			foreach($partisipan as $key => $partisipan)
			{
				DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $partisipan->id_mahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => '7']);
			}
			foreach ($request->table as $key => $idMahasiswa) {
					DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => $idstatus]);
			}

			/*
				Jika ada tahapan berikutnya, maka masukkan nama finalis ke db untuk tahap berikutnya
			*/
			$retrTahapan = DB::table('beasiswa_penyeleksi')->where('id_beasiswa', $request->idbeasiswa)
			->join('beasiswa_penyeleksi_tahapan','beasiswa_penyeleksi.id_bp','=','beasiswa_penyeleksi_tahapan.id_bp')
			->join('tahapan','beasiswa_penyeleksi_tahapan.id_tahapan','=','tahapan.id_tahapan')
			->join('user','beasiswa_penyeleksi.id_penyeleksi','=','user.id_user')
			->select('beasiswa_penyeleksi_tahapan.id_tahapan', 'tahapan.nama_tahapan','beasiswa_penyeleksi.id_penyeleksi')
			->orderBy('beasiswa_penyeleksi_tahapan.id_bpt', 'asc')->get();
			$set=0;

			foreach ($retrTahapan as $key => $tahapan) {
				if (count($retrTahapan)-1 == $key)
				{
					DB::table('seleksi_beasiswa')
					->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
					->where('id_tahapan', $request->idtahapan)
					->update(['final' => '1']);
					foreach ($request->table as $key => $idMahasiswa) {
							DB::table('penerima_beasiswa')->insert(
								['id_beasiswa' => $request->idbeasiswa,
								'id_mahasiswa'=>$idMahasiswa
							]
						);
						DB::table('pendaftaran_beasiswa')->where('id_mahasiswa', $idMahasiswa)->where('id_beasiswa', $request->idbeasiswa)->update(['status_lamaran' => '6']);
					}
				}
				if ($set==1)
				{
					$set=$tahapan->id_tahapan;
          $idpenyeleksi = DB::table('beasiswa_penyeleksi_tahapan')->join('beasiswa_penyeleksi', 'beasiswa_penyeleksi.id_bp', '=', 'beasiswa_penyeleksi_tahapan.id_bp')
                          ->where('id_beasiswa',$request->idbeasiswa)->where('id_tahapan',$set)->first();
					DB::table('seleksi_beasiswa')
					->where('id_beasiswa', $request->idbeasiswa)->where('id_penyeleksi', $request->pengguna)
					->where('id_tahapan', $request->idtahapan)
					->update(['final' => '1']);
					foreach ($request->table as $key => $idMahasiswa) {
							DB::table('seleksi_beasiswa')->insert(
								['id_beasiswa' => $request->idbeasiswa,
								'id_penyeleksi'=>$idpenyeleksi->id_penyeleksi,
								'id_tahapan'=>$set,
								'id_mahasiswa'=>$idMahasiswa
							]
						);
					}
					break;
				}
				else if ($tahapan->id_tahapan == $request->idtahapan)
				{
					$set=1;
				}
			}

			return response()->json(array('msg'=> $set), 200);
		}

    function penerimaBeasiswa($idBeasiswa) {
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;
      if ($namarole=='Mahasiswa')
      {
        return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
      }
      //Retrieve role pegawai
      else if($namarole=='Pegawai'){
        $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
        //get nama dan nilai pendaftar beasiswa untuk tahap ini
        $beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
        $penerima = DB::table('penerima_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)->get();

        /*$namaPenerima = DB::table('user')->where('id_user',$penerima->id_mahasiswa)->get();*/
        // return var_dump($penerima->pluck('id_mahasiswa'));
        $namaPenerima = DB::table('user')
        ->whereIn('id_user', $penerima->pluck('id_mahasiswa'))
        ->where('id_beasiswa', $idBeasiswa)
        ->join('penerima_beasiswa', 'user.id_user', '=', 'penerima_beasiswa.id_mahasiswa')
        ->select('user.*')
        ->get();
        return view('pages.nama-penerima')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withBeasiswa($beasiswa)->withPenerima($penerima)->withNamapenerima($namaPenerima);
      }
      else {
      	 $pendonor = DB::table('pendonor')->where('id_user', $pengguna->id_user)->first();
        //get nama dan nilai pendaftar beasiswa untuk tahap ini
        $beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
        $penerima = DB::table('penerima_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)->get();


    if ($beasiswa->id_pendonor==$pendonor->id_user)
    {
        /*$namaPenerima = DB::table('user')->where('id_user',$penerima->id_mahasiswa)->get();*/
        // return var_dump($penerima->pluck('id_mahasiswa'));
        $namaPenerima = DB::table('user as us')
        ->join('penerima_beasiswa as pb', 'pb.id_mahasiswa', '=', 'us.id_user')
        ->join('beasiswa as b','b.id_beasiswa' , '=' , 'pb.id_beasiswa')
        ->where('pb.id_beasiswa', $idBeasiswa)
        ->select('us.nama as nama', 'b.nama_beasiswa as nama_beasiswa','us.email as email')
        ->get();
         return view('pages.nama-penerima')->withUser($user)->withPengguna($pengguna)->withNamarole($namarole)->withBeasiswa($beasiswa)->withPenerima($penerima)->withNamapenerima($namaPenerima);
      }
      else {
      	 return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
      }
    }
}
}
