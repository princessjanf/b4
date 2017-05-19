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
      $user = SSO::getUser();
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

        /*$namaPenerima = DB::table('user')->where('id_user',$penerima->id_mahasiswa)->get();*/
        // return var_dump($penerima->pluck('id_mahasiswa'));
        $namaPenerima = DB::table('user as us')
        ->join('penerima_beasiswa as pb', 'pb.id_mahasiswa', '=', 'us.id_user')
        ->join('beasiswa as b','b.id_beasiswa' , '=' , 'pb.id_beasiswa')
        ->where('pb.id_beasiswa', $idBeasiswa)
        ->select('us.nama as nama', 'b.nama_beasiswa as nama_beasiswa','us.email as email')
        ->get();

        $namaDitolak = DB::table('pendaftaran_beasiswa')->where('id_beasiswa', $idBeasiswa)->where('status_lamaran', 7)->join('user', 'user.id_user','=', 'pendaftaran_beasiswa.id_mahasiswa')
        ->join('beasiswa','beasiswa.id_beasiswa','=','pendaftaran_beasiswa.id_beasiswa')->select('user.nama', 'beasiswa.nama_Beasiswa', 'user.email') ->get();
        
foreach ($namaPenerima as $np) {
   $data = array(
   'name'=> $np->nama,
   'email'=> $np->email,
   'subject'=> 'Informasi Penerimaan Beasiswa',
   'messagea' =>' Selamat Anda diterima di beasiswa '.$beasiswa->nama_beasiswa
   );
    //kirim email
  Mail::send('pages.send-mail', $data, function($message) use ($data)
  {
   $message->to($data['email']);
    $message->from('adindanadinta@gmail.com');
    $message->subject($data['subject']);
     //echo ("Basic Email Sent. Check your inbox.");
  });
  return view('pages.notif-email')->withUser($user)->withNamarole($namarole);
}
  foreach ($namaDitolak as $nd) {
   $data = array(
   'name'=> $nd->nama,
   'email'=> $nd->email,
   'subject'=> 'Informasi Penerimaan Beasiswa',
   'messagea' => $beasiswa->nama_beasiswa
   );
    //kirim email
  Mail::send('pages.email-ditolak', $data, function($message) use ($data)
  {
   $message->to($data['email']);
    $message->from('adindanadinta@gmail.com');
    $message->subject($data['subject']);
     //echo ("Basic Email Sent. Check your inbox.");
  });
   return view('pages.email-ditolak')->withUser($user)->withNamarole($namarole);
}

}
else if ($namarole=='Pendonor'){
  // return var_dump($pengguna->id_user);
        $pendonor = DB::table('pendonor')->where('id_user', $pengguna->id_user)->first();
        //get nama dan nilai pendaftar beasiswa untuk tahap ini
        $beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
        $penerima = DB::table('penerima_beasiswa')->where('id_beasiswa',$beasiswa->id_beasiswa)->get();


    if ($beasiswa->id_pendonor==$pendonor->id_user) {
        /*$namaPenerima = DB::table('user')->where('id_user',$penerima->id_mahasiswa)->get();*/
        // return var_dump($penerima->pluck('id_mahasiswa'));
        $namaPenerima = DB::table('user as us')
        ->join('penerima_beasiswa as pb', 'pb.id_mahasiswa', '=', 'us.id_user')
        ->join('beasiswa as b','b.id_beasiswa' , '=' , 'pb.id_beasiswa')
        ->where('pb.id_beasiswa', $idBeasiswa)
        ->select('us.nama as nama', 'b.nama_beasiswa as nama_beasiswa','us.email as email')
        ->get();

        $namaDitolak = DB::table('pendaftaran_beasiswa')->where('id_beasiswa', $idBeasiswa)->where('status_lamaran', 7)->join('user', 'user.id_user','=', 'pendaftaran_beasiswa.id_mahasiswa')
        ->join('beasiswa','beasiswa.id_beasiswa','=','pendaftaran_beasiswa.id_beasiswa')->select('user.nama', 'beasiswa.nama_Beasiswa', 'user.email') ->get();

foreach ($namaPenerima as $np) {
   $data = array(
   'name'=> $np->nama,
   'email'=> $np->email,
   'subject'=> 'Informasi Penerimaan Beasiswa',
   'messagea' =>' Selamat Anda diterima di beasiswa '.$beasiswa->nama_beasiswa
   );
   // return var_dump($namaPenerima);
    //kirim email
  Mail::send('pages.send-mail', $data, function($message) use ($data)
  {
   $message->to($data['email']);
    $message->from('adindanadinta@gmail.com');
    $message->subject($data['subject']);
     //echo ("Basic Email Sent. Check your inbox.");
  });
   return view('pages.notif-email')->withUser($user)->withNamarole($namarole);
}

foreach ($namaDitolak as $nd) {
 $data = array(
 'name'=> $nd->nama,
 'email'=> $nd->email,
 'subject'=> 'Informasi Penerimaan Beasiswa',
 'messagea' => $beasiswa->nama_beasiswa
 );
  //kirim email
Mail::send('pages.email-ditolak', $data, function($message) use ($data)
{
 $message->to($data['email']);
  $message->from('adindanadinta@gmail.com');
  $message->subject($data['subject']);
   //echo ("Basic Email Sent. Check your inbox.");
});
 return view('pages.email-ditolak')->withUser($user)->withNamarole($namarole);
}
        // BELUM: cek if tahapan ini udah final atau belum, kalau udah final cuma bisa lihat hasil seleksi
} else {
  return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
}
        //get nama dan nilai pendaftar beasiswa untuk tahap ini
        $beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();


      }
}
}
