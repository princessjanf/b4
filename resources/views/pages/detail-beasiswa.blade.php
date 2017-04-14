@extends('master')

@section('title', 'Detail Beasiswa')

@section('content')
@if ($namarole=='Direktorat Kerjasama')
<h4>Detail Beasiswa &nbsp;<a href="#upload"><button class="btn btn-success"><b>Upload</b></button></a></h4>
@elseif ($namarole=='mahasiswa')
<<<<<<< HEAD
<h4>Detail Beasiswa &nbsp;<a href="{{url('/daftar-beasiswa/'.$beasiswa->id_beasiswa)}}"><button class="btn btn-default"><b>Daftar</b></button></a></h4>
=======
  @if($beasiswa -> link_seleksi == null)
    <h4>Detail Beasiswa &nbsp;<a href= "{{ url('daftar-beasiswa/'.$beasiswa->id_beasiswa) }}"><button class="btn btn-default"><b>Daftar</b></button></a></h4>
  @else
    <h4>Detail Beasiswa &nbsp;<a href={{$beasiswa->link_seleksi}}><button class="btn btn-default"><b>Daftar</b></button></a></h4>
  @endif
>>>>>>> origin/development
@elseif ($namarole=="Pegawai Universitas")
<h4>Detail Beasiswa &nbsp;
  <a href = "{{ url('edit-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit" role="button"">
    <span class="glyphicon glyphicon-pencil"></span>
  </a>
  <a href = "{{ url('delete-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-danger" data-toggle="tooltip" title="Hapus" role="button">
    <span class="glyphicon glyphicon-trash"></span>
  </a>
  <a href = "{{ url('make-public-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info" data-toggle="tooltip" title="Make Public" role="button">
    <span class="glyphicon glyphicon-eye-open"></span>
  </i></button></a>
</h4>
@else
<h4>Detail Beasiswa</h4>
@endif
<h2>{{$beasiswa->nama_beasiswa}}</h2>
<p>{{$beasiswa->deskripsi_beasiswa}}</p>
<p>Periode Beasiswa:  {{$beasiswa->tanggal_buka}} - {{$beasiswa->tanggal_tutup}}</p>
<p>Persyaratan:
  @if (count($persyaratans) < 1)
  <br>1. -
  @else
  @foreach ($persyaratans as $index => $persyaratan)
  <br>{{$index+1}}. {{$persyaratan->syarat}}
  @endforeach
  @endif
</p>
@if ($namarole=='pendonor' && $ispendonor)
<p>Pendaftar:
  @if (count($pendaftars) < 1)
  <br>1. -
  @else
  @foreach ($pendaftars as $index => $pendaftar)
  <br>{{$index+1}}. {{$pendaftar->nama}}
  @endforeach
  @endif
</p>
@endif

<br>
<br>
<br>
<br>
<br>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
@endsection
