@extends('master')

@section('title', 'Profil')

@section('content')
@if (session('namaberkas'))
    <div class="alert alert-success">
        Berkas telah <b> berhasil </b> diunggah.
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
    <table id="tabel1" class="table table-bordered">
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
    <th><label id="dp{{$index}}"></label></th>
    <th><label id="dh{{$index}}"></label></th>
    <script>

    var nStr = "{{$beasiswa->dana_pendidikan}}".toString();
    var dStr = "{{$beasiswa->dana_hidup}}".toString();

    var x1 = nStr.replace (/,/g, "");
    var x2 = nStr.replace (/,/g, "");

    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    while (rgx.test(x2)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }

    document.getElementById("dp{{$index}}").innerHTML = "{{$beasiswa->nama_mata_uang}} "+ x1;
    document.getElementById("dh{{$index}}").innerHTML = "{{$beasiswa->nama_mata_uang}} "+ x2;

    </script>
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
     <p><label id="penghasilan"></label></p>
     <script>

     var nStr = "{{$mahasiswa->penghasilan_orang_tua}}".toString();
     var x1 = nStr.replace (/,/g, "");

     var rgx = /(\d+)(\d{3})/;
     while (rgx.test(x1)) {
       x1 = x1.replace(rgx, '$1' + ',' + '$2');
     }
     console.log(x1);
     document.getElementById('penghasilan').innerHTML = 'IDR ' + x1;

     </script>
     </div>
     </div>

     <h4>Berkas Umum:</h4>
     @foreach($berkas as $index => $file)
     <form action="{{url('download-berkas')}}" method="POST">
       <input type="text" value="{{$file->file}}" name="berkas" hidden>
       <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
       <input type="hidden" value="{{$user->username}}" name="username">
       <label class="form-group">{{$index+1}}.</label>
       <button class="btn" type="submit">Download</button>
       <label>{{$file->nama_berkas}}</label>
     </form>
     @endforeach
     <a href="{{url('upload-berkas-umum')}}"><button class="btn btn-info">UNGGAH BARU</button></a>
     <br><br>

    <h4>Daftar Beasiswa yang Didaftarkan:</h4>
   <p></p>
    <table id="tabel2" class="table table-striped">
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
    </br></br></br></br></br></br></br></br></br>
    </br></br></br></br></br></br></br></br></br>
    </br></br></br></br></br></br></br></br></br>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tabel1').DataTable();
    $('#tabel2').DataTable();
	});
</script>
@endsection
