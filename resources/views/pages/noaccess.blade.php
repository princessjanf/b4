@extends('master')
@section('title', 'Access Denied!')

@section('content')
<style>
#sidebar {
	display: none;
}
</style>

<div class="container">
	<img style="display:block; margin:auto; width:35%;" src="{{ asset('img/warning.png') }}"  width="70">
	<h1 style="text-align:center;"> Maaf, Anda tidak memiliki akses ke halaman ini </h1>
	<h3 style="text-align:center;"> <a href="{{ url('homepage') }}"> Kembali ke Homepage </a></h3>
</div>
@endsection
