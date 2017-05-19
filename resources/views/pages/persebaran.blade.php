@extends('master')

@section('title', 'Statistik')

@section('head')
{!! Charts::assets() !!}
@endsection

@section('content')
<h3 style='text-align:center;'> Persebaran Beasiswa </h3>
<br>{!! $jenjang->render() !!}
<a href="{{ url('lihat-statistik2') }}"> <h5 style='text-align:center;'> Lihat Detail Persebaran Beasiswa Per Jenjang </h5></a>
</br></br>
<br>{!! $fakultas->render() !!}
<a href="{{ url('lihat-statistik5') }}"> <h5 style='text-align:center;'> Lihat Detail Persebaran Beasiswa Per Fakultas </h5></a>
<br>{!! $prodi->render() !!}
<a href="{{ url('lihat-statistik6') }}"> <h5 style='text-align:center;'> Lihat Detail Persebaran Beasiswa Per Prodi </h5></a>
@endsection
@section('script')

@endsection
