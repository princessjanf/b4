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
        DB::insert('INSERT INTO `user`(`username`, `nama`, `email`, `id_role`)
                    VALUES (?,?,?,1)',
                    [
                       $user->username,
                        $user->name,
                        $user->username."@ui.ac.id"
                    ]
                  );
        DB::insert('INSERT INTO `mahasiswa`(`username`, `npm`, `id_fakultas`, `id_prodi`)
                    VALUES (?,?,1,1)',
                    [
                       $user->username,
                        $user->npm
                    ]
                  );
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
      if ($namarole == 'mahasiswa' || $namarole == 'Pegawai Fakultas') {
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get();
      } else if ($namarole == 'pendonor'){
        $pendonor = DB::table('pendonor')->where('id_user', $pengguna->id_user)->first();
        $beasiswas = collect(DB::table('beasiswa')->where('flag', '1')->where('public', '1')->get());
        $beasiswas2= collect(DB::table('beasiswa')->where('flag', '1')->where('public', '0')->where('id_pendonor', $pendonor->id_pendonor)->get());
        $beasiswas = $beasiswas->merge($beasiswas2)->sort()->values()->all();
      } else {
        $beasiswas = DB::table('beasiswa')->where('flag', '1')->get();
      }
      return view('pages.list-beasiswa')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole);
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
      $persyaratans = DB::table('persyaratan')->where('id_beasiswa', $beasiswa->id_beasiswa)->get();
      if ($namarole=='pendonor')
      {
        $isPendonor = false;
        $pendonor = DB::table('beasiswa')
                    ->where('id_beasiswa', $beasiswa->id_beasiswa)
                    ->join('pendonor', 'beasiswa.id_pendonor', '=', 'pendonor.id_pendonor')
                    ->select('pendonor.*')
                    ->first();
        if ($pendonor->username == $user->username)
        {
          $isPendonor = true;
        }
        $pendaftars = DB::table('melamar')
                    ->where('id_beasiswa', $beasiswa->id_beasiswa)
                    ->join('user', 'melamar.username', '=', 'user.username')
                    ->select('melamar.*', 'user.nama')
                    ->get();
        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole)->withPendaftars($pendaftars)->withIspendonor($isPendonor);
      }
      else
      {
        return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans)->withUser($user)->withNamarole($namarole);
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
            ->select('beasiswa.*')
            ->get();
           
            return view('pages.profil')->withPengguna($pengguna)->withNama($nama)->withUser($user)->withMahasiswa($mahasiswa)->withNamarole($namarole)->withBeasiswas($beasiswas)->withFakultas($fakultas)->withProdi($prodi)->withJenjangmahasiswa($jenjangMahasiswa);
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
         $jenjang = DB::table('jenjang_prodi')->where('id_prodi',$mahasiswa->id_prodi)->first();
             $jenjangMahasiswa = DB::table('jenjang')->where('id_jenjang',$jenjang->id_jenjang)->first();
             
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
                  ]);
          $idUser = $request->get('idUser');


          $user = SSO::getUser();
          $pengguna = DB::table('user')->where('username', $user->username)->first();

        // DB::insert('insert into `log_beasiswa` (`id_beasiswa`, `tipe_perubahan`, `id_user`) VALUES (?,?,?)', [$beasiswa->id_beasiswa, 'modifikasi', $pengguna->username]);

          return redirect('profil');
}

}

