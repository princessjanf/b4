@extends('master')

@section('title', 'Statistik')

@section('head')
{!! Charts::assets() !!}
@endsection

@section('content')

<form action="{{url('lihat-statistik6')}}" method="POST">
	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
	<select class="form-control" style="width:auto" name="selected" onchange="this.form.submit()" required>
		@foreach ($prodi as $nama_prodi)
		@if($selected == $nama_prodi)
		<option value="{{$nama_prodi}}" selected>{{$nama_prodi}}</option>
		@else
		<option value="{{$nama_prodi}}">{{$nama_prodi}}</option>
		@endif
		@endforeach
	</select>
</form>
<br>{!! $chart->render() !!}
@endsection

@section('script')

@endsection
