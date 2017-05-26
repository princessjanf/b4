@extends('master')

@section('title', 'Statistik')

@section('head')
{!! Charts::assets() !!}
@endsection

@section('content')
<form action="{{url('persebaranPerBeasiswa')}}" method="POST">
	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
	<select class="form-control" style="width:auto" name="selected" onchange="this.form.submit()" required>
		@foreach ($beasiswas as $beasiswa)
		@if($selected == $beasiswa->nama_beasiswa)
		<option value="{{$beasiswa->nama_beasiswa}}" selected>{{$beasiswa->nama_beasiswa}}</option>
		@else
		<option value="{{$beasiswa->nama_beasiswa}}">{{$beasiswa->nama_beasiswa}}</option>
		@endif
		@endforeach
	</select>
</form>
<br>{!! $chart->render() !!}

<h4 style="text-align:center";> Detail</h4>
<table id="beasiswalist" class="table table-striped">
		<thead>
				<tr>
						<th> No </th>
						<th> Nama Penerima</th>
				</tr>
		</thead>
		<tbody>
			@foreach($dataset as $index => $data)
				<tr>
					<td> {{$index+1}} </td>
					<td> {{$data->nama}} </td>
				</tr>
			@endforeach
		</tbody>
</table>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#beasiswalist').DataTable();
	});
</script>
@endsection
