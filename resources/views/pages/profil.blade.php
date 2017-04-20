@extends('master')

@section('title', 'Profil')

@section('content')
      <li><a href="{{url('edit-profil')}}">Edit</a></li>
      <p></p>
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
       @foreach($beasiswas as $index => $beasiswa)
    <p><label>{{$index+1}} {{$beasiswa->nama_beasiswa}}</label></p>
    @endforeach

   @elseif($namarole=='Mahasiswa')
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

    DAFTAR BEASISWA YANG DIDAFTAR:
    @foreach($beasiswas as $index => $beasiswa)
    <p><label>{{$index+1}}. {{$beasiswa->nama_beasiswa}} - {{$beasiswa->nama_lamaran}}</label></p>

    @endforeach

 
    @endif
    </div>
@endsection


