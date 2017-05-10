@extends('master')

@section('title', 'Statistik')

@section('head')
	{!! Charts::assets() !!}
@endsection

@section('content')
	<div class="col-sm-12">
		{!! $chart->render() !!}
	</div>
@endsection

@section('script')
@endsection
