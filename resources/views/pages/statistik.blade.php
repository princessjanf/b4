@extends('master')

@section('title', 'Lihat Statistik')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section('content')
<h1 style="text-align:center";> LIHAT STATISTIK </h1>
<hr>
</br>
</br>

@if($namarole != 'Mahasiswa')
<style>
.col1{
    width:100px;
    height:100px;
    position:relative;
    background:transparent;
}

.fa fa-users fa-5x{
    position:absolute;
    top:45%;
    left:45%;
    color: white;
}
</style>
 
    <div class = "col-sm-6">
		<a style='text-align: center' href="{{ url('statistik-persebaran') }}"> <p style='text-align: center'> <i class=" fa fa-graduation-cap fa-5x"></i></p><h4 style="color: #1a75ff;">Persebaran Beasiswa</h4> </a>
		<div class = "col-sm-4">
		<a href="{{ url('lihat-statistik2') }}"> <p style='text-align: center'> <i class=" fa fa-university fa-3x"></i></p><h6 style='text-align: center' style="color: #4d94ff;">Beasiswa Per Jenjang</h6> </a>
		</div>
		<div class = "col-sm-4">
		<a href="{{ url('lihat-statistik5') }}"> <p style='text-align: center'> <i class=" fa fa-university fa-3x"></i></p><h6 style='text-align: center' style="color: #4d94ff;">Beasiswa Per Fakultas</h6> </a>
		</div>
		<div class = "col-sm-4">
		<a href="{{ url('lihat-statistik6') }}"> <p style='text-align: center'> <i class=" fa fa-university fa-3x"></i></p><h6 style='text-align: center' style="color: #4d94ff;">Beasiswa Per Prodi</h6> </a>
		</div>
		</br>
	</div>


@endif
 <div class = "col-sm-6">
<a style='text-align: center' href="{{ url('statistik-penerima') }}"> <p style='text-align: center'> <i class=" fa fa-users fa-5x"></i></p><h4 style="color: #1a75ff;">Persebaran Penerima-Pendaftar Beasiswa</h4> </a>
<div class = "col-sm-3">
</div>
<div class = "col-sm-3">
<a href="{{ url('lihat-statistik4') }}"> <p style='text-align: center'> <i class=" fa fa-university fa-3x"></i></p><h6 style='text-align: center' style="color: #4d94ff;">Penerima Per Fakultas</h5> </a>
</br>
</br>
</div>
<div class = "col-sm-3">
<a href="{{ url('lihat-statistik7') }}"> <p style='text-align: center'> <i class=" fa fa-university fa-3x"></i></p><h6 style='text-align: center' style="color: #4d94ff;">Penerima Per Prodi</h5> </a>
</div>
</br>
</br>
</div>
<div class = "col-sm-3">
</div>
@if($namarole != 'Mahasiswa')
 <div class = "col-sm-11">
<a style='text-align: center' href="{{ url('lihat-statistik-dana') }}"> <p style='text-align: center'> <i class=" fa fa-usd fa-5x"></i></p><h4 style="color: #1a75ff;">Lihat Penerimaan Dana Beasiswa</h4> </a>
</div>

@endif
</br></br></br></br></br></br></br></br></br>
</br></br></br></br></br></br></br></br></br>
@endsection



@section('script')
<!-- script references -->>
<script type="text/javascript" src="{{ URL::asset('js/multiple-select.js') }}"></script>
<script>
</script>
@endsection
