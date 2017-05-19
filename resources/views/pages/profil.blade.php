@extends('master')

@section('title', 'Profil')

@section('content')
@if (session('namaberkas'))
    <div class="alert alert-success">
        Berkas {{ session('namaberkas') }} milik  {{ session('namamahasiswa') }} telah <b> berhasil </b> diunggah.
    </div>

@elseif (session('namaberkastimpa'))
    <div class="alert alert-success">
        Berkas {{ session('namaberkastimpa') }} milik  {{ session('namamahasiswatimpa') }} telah <b> berhasil </b> diperbaharui.
    </div>
@endif

    <div class="col-sm-9">
    <H2>PROFIL</H2>
    <HR></HR>
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
      <br>

      NAMA BEASISWA YANG DI DONORKAN:
       <p></p>
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>No.</th>
        <th>Nama Beasiswa</th>
        <th>Dana Pendidikan</th>
        <th>Dana Hidup</th>
      </tr>
    </thead>
    <tbody>
  @if (count($beasiswas)==0)
  <tr>
  <th><label>1. </label></th>
  <th>-</th>
  <th>-</th>
  <th>-</th>
  </tr>
  @else

   @foreach($beasiswas as $index => $beasiswa)
   <tr>
    <th><label>{{$index+1}}.</label></th>
    <th><label><a href="{{ url('pendaftar-beasiswa/'.$beasiswa->id_beasiswa) }}">{{$beasiswa->nama_beasiswa}}</a></label></th>
    <th><label>{{$beasiswa->dana_pendidikan}}</label></th>
    <th><label>{{$beasiswa->dana_hidup}}</label></th>
  </tr>
   @endforeach

   @endif
   </tbody>
    </table>

   @elseif($namarole=='Mahasiswa')

  <p><a href="{{url('edit-profil')}}"><button type="button" class="btn btn-info">Edit Profil</button></a></p>

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

     <h4>Berkas Umum:</h4>
     @foreach($berkas as $index => $file)
     <form action="{{url('download-berkas')}}" method="POST">
       <input type="text" value="{{$file->file}}" name="berkas" hidden>
       <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
       <label class="form-group">{{$index+1}}.</label>
       <button class="btn" type="submit">Download</button>
       <label>{{$file->nama_berkas}}</label>
     </form>
     @endforeach
     <a href="{{url('upload-berkas-umum')}}"><button class="btn btn-info">UNGGAH BARU</button></a>
     <br><br>

    <h4>Daftar Beasiswa yang Didaftarkan:</h4>
   <p></p>
    <table class="table table-striped">
    <thead>
      <tr>
        <th >No.</th>
        <th>Nama Beasiswa</th>
        <th width="25%">Waktu Melamar</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
    <tr>
    @foreach($beasiswas as $index => $beasiswa)
    <th><label>{{$index+1}}.</label></th>
    <th><label><a href="{{ url('detail-beasiswa/'.$beasiswa->id_beasiswa) }}">{{$beasiswa->nama_beasiswa}}</a></label></th>
   <!--  <th><label>{{$beasiswa->nama_beasiswa}}</label></th> -->
   <th><label>{{$beasiswa->waktu_melamar}}</label></th>
   <th><label>{{$beasiswa->nama_lamaran}}</label></th>
   </tr>
    @endforeach
   </tbody>
    </table>



    @endif
    </div>
@endsection
