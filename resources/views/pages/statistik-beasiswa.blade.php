@extends('master')

@section('title', 'Statistik')

@section('head')
	{!! Charts::assets() !!}
@endsection

@section('content')
	<div class="col-sm-12">
		{!! $chart[0]->render() !!}
		{!! $chart[1]->render() !!}
		{!! $chart[2]->render() !!}
		{!! $chart[3]->render() !!}
	</div>
@endsection

@section('script')
@endsection
