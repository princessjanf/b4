@extends('master')

@section('title', 'Pendaftar Beasiswa')

@section('content')
<div class="col-sm-9">
    <H2>PENDAFTAR BEASISWA</H2>
    <HR></HR>

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
         <tr>
           @foreach($mahasiswas as $index => $mahasiswa)
            <th><label>{{$index+1}}.</label></th>
           <th><label><a href="{{ url('lihat-berkas-mahasiswa/'.$mahasiswa->id_user) }}">{{$mahasiswa->nama}}</a></label></th>
           <th><label>{{$mahasiswa->npm}}</label></th>
           <th><label>{{$mahasiswa->email}}</label></th>
           <th><label>{{$mahasiswa->nama_fakultas}}</label></th>
           <th><label>{{$mahasiswa->nama_prodi}}</label></th>
         </tr>
            @endforeach
      </tbody>
      
    </table>

    <div>
      <button id="cancel" class="btn btn-danger" formnovalidate><a href="{{ url('profil') }}">Back </a></button>
    </div>

</div>
@endsection

