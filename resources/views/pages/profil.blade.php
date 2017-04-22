<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Profil</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

@extends('master')

@section('title', 'Profil')

@section('content')
    <div class="col-sm-9">
    @if($namarole=='Pegawai Universitas'||$namarole=='Pegawai Fakultas'||$namarole=='Direktorat Kerjasama')
     NAMA:
     <p><label>{{$pengguna->nama}}</label></p>
     NIK:
     <p><label>{{$pegawai->no_identitas}}</label></p>
     JABATAN:
      <p><label>{{$jabatan->nama_jabatan}}</label></p>
    
    @elseif($namarole=='Pendonor')
    NAMA INSTANSI:
     <p><label>{{$pendonor->nama_instansi}}</label></p>
     NAMA:
      <p><label>{{$pengguna->nama}}</label></p>

      NAMA BEASISWA YANG DI DONORKAN:
       <p></p>
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama Beasiswa</th>
      </tr>
    </thead>
    <tbody>
    <tr>
   @foreach($beasiswas as $index => $beasiswa)
    <th><label>{{$index+1}}.</label></th>
   <th><label>{{$beasiswa->nama_beasiswa}}</label></th>
   </tr>
   @endforeach
   </tbody>
    </table>

   @elseif($namarole=='Mahasiswa')
   <div class="container">
  <p><a href="{{url('edit-profil')}}"><button type="button" class="btn btn-info">Edit Profil</button></a></p>
   </div>
   <p></p>
    <div class="row">
    <div class = "col-sm-6">
   NAMA:
   <p><label>{{$pengguna->nama}}</label></p>
   FAKULTAS
   <p><label>{{$fakultas->nama_fakultas}}</label></p>
   PROGRAM STUDI
   <p><label>{{$prodi->nama_prodi}}</label></p>
   JENJANG:
   <p><label>{{$jenjangmahasiswa->nama_jenjang}}</label></p>
   IPK:
   <p><label>{{$mahasiswa->IPK}}</label></p>
   NO. REKENING:
   <p><label>{{$mahasiswa->nomor_rekening}}</label></p>
   NAMA BANK:
    <p><label>{{$mahasiswa->nama_bank}}</label></p>
    </div>
    <div class = "col-sm-6">
   JENIS IDENTITAS:
    <p><label>{{$mahasiswa->jenis_identitas}}</label></p>
    NO. IDENTITAS:
     <p><label>{{$mahasiswa->nomor_identitas}}</label></p>
    NO.TELEPON:
     <p><label>{{$mahasiswa->nomor_telepon}}</label></p>
    NO. HANDPHONE:
     <p><label>{{$mahasiswa->nomor_telepon}}</label></p>
    NAMA PEMILIK REKENING:
     <p><label>{{$mahasiswa->nama_pemilik_rekening}}</label></p> 
    PENGHASILAN ORANG TUA:
     <p><label>{{$mahasiswa->penghasilan_orang_tua}}</label></p>
     </div>
     </div>
    DAFTAR BEASISWA YANG DIDAFTAR:
   <p></p>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama Beasiswa</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    @foreach($beasiswas as $index => $beasiswa)
    <th><label>{{$index+1}}.</label></th>
   <th><label>{{$beasiswa->nama_beasiswa}}</label></th>
   <th><label>{{$beasiswa->nama_lamaran}}</label></th>
   </tr>
    @endforeach
   </tbody>
    </table>
    

 
    @endif
    </div>
@endsection

</html>