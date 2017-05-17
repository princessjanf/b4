@extends('master')

@section('title', 'Statistik')

@section('head')
	{!! Charts::assets() !!}
@endsection

@section('content')
	<div class="col-sm-12">
	 @foreach($beasiswa as $index => $beasiswaa)
   <p>Pendaftar Beasiswa {{$beasiswaa->nama_beasiswa}}</p>
   @endforeach
	
		{!! $chart[0]->render() !!}
	</div>
@endsection

@section('script')
@endsection
