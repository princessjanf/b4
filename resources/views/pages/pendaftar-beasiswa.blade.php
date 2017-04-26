@extends('master')

@section('title', 'Pendaftar Beasiswa')

@section('content')
<div class="col-sm-9">
    <H2>PENDAFTAR BEASISWA</H2>
    <HR></HR>
    <h3>{{$beasiswa->nama_beasiswa}}</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Mahasiswa</th>
          <th>NPM</th>
          <th>Email</th>
          <th>Fakultas</th>
          <th>Jurusan</th>
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
         </tr>
            @endforeach
            @endif
      </tbody>

    </table>

    <div>
      <a href="{{ url('profil') }}"><button id="cancel" class="btn btn-info" type="button" formnovalidate>Back</button></a>
    </div>

</div>
@endsection
