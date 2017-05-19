@extends('master')

@section('title', 'Lihat Statistik')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<h2 style="text-align:center";> Lihat Statistik </h2>
</br> </br>
<a href="{{ url('statistik-persebaran') }}"> <h4>Persebaran Beasiswa</h4> </a>
<a href="{{ url('lihat-statistik2') }}"> <h5>Persebaran Beasiswa Per Jenjang</h5> </a>
<a href="{{ url('lihat-statistik5') }}"> <h5>Persebaran Beasiswa Per Fakultas</h5> </a>
<a href="{{ url('lihat-statistik6') }}"> <h5>Persebaran Beasiswa Per Prodi</h5> </a>

<a href="{{ url('statistik-penerima') }}"> <h4>Persebaran Penerima-Pendaftar Beasiswa</h4> </a>
<a href="{{ url('lihat-statistik4') }}"> <h5>Persebaran Penerima-Pendaftar Beasiswa Per Fakultas</h5> </a>
<a href="{{ url('lihat-statistik7') }}"> <h5>Persebaran Penerima-Pendaftar Beasiswa Per Prodi</h5> </a>

@endsection

@section('script')
<!-- script references -->>
<script type="text/javascript" src="{{ URL::asset('js/multiple-select.js') }}"></script>
<script>
</script>
@endsection
