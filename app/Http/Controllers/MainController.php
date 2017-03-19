@@ -9,10 +9,15 @@ use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    function index()
    {

<<<<<<< HEAD
<<<<<<< HEAD
    function index()
    {
=======
>>>>>>> refs/remotes/origin/master

      if(!SSO::check()) {
        $user = null;
@@ -20,8 +25,24 @@ class MainController extends Controller
      }
      else{
        $user = SSO::getUser();
<<<<<<< HEAD
        return view('pages.homepage')->withUser($user);
      }
=======
        $pengguna = DB::table('user')->where('username', $user->username)->first();
        $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
        $namarole = $role->nama_role;

        if($namarole=='pegawai'){
          $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
          $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
          $namarole = $role->nama_role_pegawai;
        }

        //$namarole disini kemungkinannya berarti = mahasiswa/pendonor/pegawai fakultas/pegawai universitas/direktorat kerjasama
          return view('pages.homepage')->withUser($user)->withNamarole($namarole);
        }
>>>>>>> refs/remotes/origin/master

    }

@@ -31,7 +52,22 @@ class MainController extends Controller
        SSO::authenticate();
      $user = SSO::getUser();

<<<<<<< HEAD
        return view('pages.beranda')->withUser($user);
=======
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='pegawai'){
        $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
      }

      //$namarole disini kemungkinannya berarti = mahasiswa/pendonor/pegawai fakultas/pegawai universitas/direktorat kerjasama
        return view('pages.homepage')->withUser($user)->withNamarole($namarole);
>>>>>>> refs/remotes/origin/master
    }

    function logout()
@@ -41,17 +77,55 @@ class MainController extends Controller

    function daftarbeasiswa()
    {
<<<<<<< HEAD
      $beasiswas = DB::table('beasiswa')->get();
      return view('pages.daftar-beasiswa')->withBeasiswas($beasiswas);
=======
      $user = SSO::getUser();
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='pegawai'){
        $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
      }

      //$namarole disini kemungkinannya berarti = mahasiswa/pendonor/pegawai fakultas/pegawai universitas/direktorat kerjasama
      $beasiswas = DB::table('beasiswa')->get();
      return view('pages.daftar-beasiswa')->withBeasiswas($beasiswas)->withUser($user)->withNamarole($namarole);
>>>>>>> refs/remotes/origin/master
    }

     function addbeasiswa()
    {
<<<<<<< HEAD
      return view('pages.add-beasiswa');
=======
      $user = SSO::getUser();

      $pengguna = DB::table('pegawai')->where('username', $user->username)->first();

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
>>>>>>> refs/remotes/origin/master
    }

    function detailbeasiswa($id)
    {
<<<<<<< HEAD
      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      $persyaratans = DB::table('persyaratan')->where('id_beasiswa', $beasiswa->id_beasiswa)->get();
      return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans);
@@ -96,4 +170,22 @@ class MainController extends Controller
    return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPersyaratans($persyaratans);
  }
>>>>>>> refs/remotes/origin/master
=======
      $user = SSO::getUser();

      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;

      if($namarole=='pegawai'){
        $pengguna = DB::table('pegawai')->where('username', $user->username)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
      }

      $beasiswa = DB::table('beasiswa')->where('id_beasiswa', $id)->first();
      $pendonor = DB::table('pendonor')->where('id_pendonor', $beasiswa->id_pendonor)->first();
      return view('pages.detail-beasiswa')->withBeasiswa($beasiswa)->withPendonor($pendonor)->withUser($user)->withNamarole($namarole);
    }
>>>>>>> refs/remotes/origin/master
}