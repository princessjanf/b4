@extends('master')

@section('title', 'Lihat Statistik')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')


<h2 style="text-align:center";> Lihat Statistik </h2>
</br> </br>
@if($namarole != 'Mahasiswa')
<a href="{{ url('statistik-persebaran') }}"> <h4 style="color: #1a75ff;">Lihat Persebaran Beasiswa</h4> </a>
<a href="{{ url('lihat-statistik2') }}"> <h5 style="color: #4d94ff;">Persebaran Beasiswa Per Jenjang</h5> </a>
<a href="{{ url('lihat-statistik5') }}"> <h5 style="color: #4d94ff;">Persebaran Beasiswa Per Fakultas</h5> </a>
<a href="{{ url('lihat-statistik6') }}"> <h5 style="color: #4d94ff;">Persebaran Beasiswa Per Prodi</h5> </a>
</br>
@endif
<a href="{{ url('statistik-penerima') }}"> <h4 style="color: #1a75ff;">Lihat Persebaran Penerima-Pendaftar Beasiswa</h4> </a>
<a href="{{ url('lihat-statistik4') }}"> <h5 style="color: #4d94ff;">Persebaran Penerima-Pendaftar Beasiswa Per Fakultas</h5> </a>
<a href="{{ url('lihat-statistik7') }}"> <h5 style="color: #4d94ff;">Persebaran Penerima-Pendaftar Beasiswa Per Prodi</h5> </a>
</br>
@if($namarole != 'Mahasiswa')
<a href="{{ url('lihat-statistik-dana') }}"> <h4 style="color: #1a75ff;">Lihat Penerimaan Dana Beasiswa</h4> </a>
@endif
@endsection

@section('script')
<!-- script references -->>
<script type="text/javascript" src="{{ URL::asset('js/multiple-select.js') }}"></script>
<script>
</script>
@endsection
