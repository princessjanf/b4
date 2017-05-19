@extends('master')

@section('title', 'Pendaftar Beasiswa')

@section('content')
<div class="col-sm-9">
    <H2>PENDAFTAR BEASISWA</H2>
    <HR></HR>
    <h3>{{$beasiswa->nama_beasiswa}}</h3>
    <table able id="pendaftarList" class="table table-striped">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Mahasiswa</th>
          <th>NPM</th>
          <th>Email</th>
          <th>Fakultas</th>
          <th>Jurusan</th>
          <th>IPK</th>
          <th>Penghasilan Orang Tua</th>
        </tr>
      </thead>

      <tbody>
           @if (count($mahasiswas)==0)
           <tr>
           <th><label>1. </label></th>
           <th>-</th>
           <th>-</th>
           <th>-</th>
           <th>-</th>
           <th>-</th>
         </tr>
           @else

           @foreach($mahasiswas as $index => $mahasiswa)
           <tr>
            <th><label>{{$index+1}}.</label></th>
           <th><label><a href="{{ url('lihat-berkas-mahasiswa/'.$beasiswa->id_beasiswa. '/' .$mahasiswa->id_user) }}">{{$mahasiswa->nama}}</a></label></th>
           <th><label>{{$mahasiswa->npm}}</label></th>
           <th><label>{{$mahasiswa->email}}</label></th>
           <th><label>{{$mahasiswa->nama_fakultas}}</label></th>
           <th><label>{{$mahasiswa->nama_prodi}}</label></th>
           <th><label>{{$mahasiswa->IPK}}</label></th>
           <th><label>{{$mahasiswa->penghasilan_orang_tua}}</label></th>
         </tr>
            @endforeach
            @endif
      </tbody>

    </table>

    <div>
      <a href="{{ url('profil') }}"><button id="cancel" class="btn btn-info" type="button" formnovalidate>Kembali</button></a>
    </div>

</div>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js'></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#pendaftarList').DataTable();
  });
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<style media="screen">
  .dataTables_filter {
    margin-left: 175px;
  }
</style>
@endsection

