@extends('master')

@section('title', 'Statistik')

@section('head')
	{!! Charts::assets() !!}
@endsection

@section('content')
	<div class="col-sm-12">
		<form action="{{url('lihat-statistik5')}}" method="POST">
			<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
			<select class="form-control" style="width:auto" name="selected" onchange="this.form.submit()" required>
				@foreach ($fakultas as $nama_fakultas)
				@if($selected == $nama_fakultas)
				<option value="{{$nama_fakultas}}" selected>{{$nama_fakultas}}</option>
				@else
				<option value="{{$nama_fakultas}}">{{$nama_fakultas}}</option>
				@endif
				@endforeach
			</select>
		</form>
	</br>

		{!! $chart->render() !!}
	</br>
	</br>
	</div>

@endsection

@section('script')
@endsection
