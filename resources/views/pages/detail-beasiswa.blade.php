@extends('master')

@section('title', 'Detail Beasiswa')

@section('content')
@if ($namarole=='Direktorat Kerjasama')
<h4>Detail Beasiswa <button class="btn"><a href="#upload"><b>Upload</b></a></button></h4>
@elseif ($namarole=='mahasiswa')
<h4>Detail Beasiswa <button class="btn"><a href="#daftar"><b>Daftar</b></a></button></h4>
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
@endsection
