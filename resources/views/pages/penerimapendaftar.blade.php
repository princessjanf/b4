@extends('master')

@section('title', 'Statistik')

@section('head')
{!! Charts::assets() !!}
@endsection

@section('content')
<h3 style='text-align:center;'> Persebaran Penerima-Pendaftar Beasiswa </h3>
{!! $chart->render() !!}
<a href="{{ url('lihat-statistik4') }}"> <h5 style='text-align:center;'> Lihat Detail Persebaran Penerima-Pendaftar Per Fakultas</h5></a>
<a href="{{ url('lihat-statistik7') }}"> <h5 style='text-align:center;'> Lihat Detail Persebaran Penerima-Pendaftar Per Prodi</h5></a>
@endsection
@section('script')

@endsection
