<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use SSO\SSO;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
class MailController extends Controller {
public function sendEmail($idBeasiswa)
{
      $pengguna = DB::table('user')->where('username', $user->username)->first();
      $role = DB::table('role')->where('id_role', $pengguna->id_role)->first();
      $namarole = $role->nama_role;
        if ($namarole=='Mahasiswa')
      {
        return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
      }
      if($namarole=='Pegawai'){
        $pengguna = DB::table('pegawai')->where('id_user', $pengguna->id_user)->first();
        $role = DB::table('role_pegawai')->where('id_role_pegawai', $pengguna->id_role_pegawai)->first();
        $namarole = $role->nama_role_pegawai;
        //get nama dan nilai pendaftar beasiswa untuk tahap ini
        $beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
        $penerima = DB::table('penerima_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)->get();

         $namaPenerima = DB::table('user as us')
        ->join('penerima_beasiswa as pb', 'pb.id_mahasiswa', '=', 'us.id_user')
        ->join('beasiswa as b','b.id_beasiswa' , '=' , 'pb.id_beasiswa')
        ->where('pb.id_beasiswa', $idBeasiswa)
        ->select('us.nama as nama', 'b.nama_beasiswa as nama_beasiswa','us.email as email')
        ->get();

      }
}

