@extends('master')
@section('title', 'Sudah Terdaftar!')

@section('content')
<style>
#sidebar {
	display: none;
}
</style>

<div class="container">
	<img style="display:block; margin:auto; width:35%;" src="{{ asset('img/checklist.png') }}"  width="70">
	<h1 style="text-align:center;"> Anda sudah mendaftar di Beasiswa Ini. <br>Silahkan tunggu pengumuman. </h1>
	<h3 style="text-align:center;"> <a href="{{ url('list-beasiswa') }}"> Kembali ke List Beasiswa </a></h3> | 
</div>
@endsection
