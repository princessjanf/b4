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

//  $data = array(
//    'name'=> $namaPenerima->pluck('nama'),
//    'email'=> $namaPenerima->pluck('email'),
//    'subject'=> 'Informasi Penerimaan Beasiswa',
//    'message' =>'Halo '.$namaPenerima->nama.' Selamat kamu diterima di beasiswa'.$beasiswa->nama_beasiswa
//    );
//  // return var_dump($data['email'][0]);


//  //kirim email
//   Mail::send('pages.send-mail', $data, function($message) use ($data)
//   {  
//    for ($i=0; $i < count($data['email']); $i++)
//     { 
//       $message->to($data['email'][$i]);
//     }
//    /*foreach($data as $idx => $data2) {
    
//    }
// }*/
//     $message->from('adindanadinta@gmail.com');
//     $message->subject($data['subject']);
//      echo ("Basic Email Sent. Check your inbox.");
//   });



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
        // BELUM: cek if tahapan ini udah final atau belum, kalau udah final cuma bisa lihat hasil seleksi
} else {
  return view('pages.noaccess')->withUser($user)->withNamarole($namarole);
}
        //get nama dan nilai pendaftar beasiswa untuk tahap ini
        $beasiswa = DB::table('beasiswa')->where('id_beasiswa',$idBeasiswa)->first();
       
        
      }
}
   /* Mail::send('pages.send-mail', ['name'=> 'Novica'], function($message)
  {
    $message->to('alvinwardhana7@gmail.com', 'Adinda Nadinta')->from('adindanadinta@gmail.com')->subject('Welcome!');

  });*/
   /*public function basic_email(){
      $data = array('name'=>"Virat Gandhi");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('dwikism@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from('adindanadinta@gmail.com','Virat Gandhi');
      });
      echo "Basic Email Sent. Check your inbox.";
   }

   public function html_email(){
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "HTML Email Sent. Check your inbox.";
   }
   
   public function attachment_email(){
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('xyz@gmail.com','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }*/
}