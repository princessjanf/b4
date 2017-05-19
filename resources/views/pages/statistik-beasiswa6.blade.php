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
</br>
</br>
@if($table == 1)
	<h4 style="text-align:center";> Detail Beasiswa </h4>
	<table id="beasiswalist" class="table table-striped">
			<thead>
					<tr>
							<th> No </th>
							<th> Nama Beasiswa </th>
							<th> Pendonor </th>
					</tr>
			</thead>
			<tbody>
				@foreach($beasiswas as $index=>$beasiswa)
					<tr>
						<td> {{$index+1}} </td>
						<td> {{$beasiswa->nama_beasiswa}} </td>
						<td> {{$beasiswa->nama_instansi}} </td>
					</tr>
				@endforeach
			</tbody>
	</table>
@endif

@endsection

@section('script')

@endsection
