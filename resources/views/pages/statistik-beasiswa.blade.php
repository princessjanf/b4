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
		<div>
			<select class="form-control" id="pendonor" name="pendonor" required>
				<option selected disabled> --Pilih Pendonor-- </option>
				@foreach ($pendonor as $pendonor)
				<option value= {{ $pendonor->id_user}}> {{$pendonor->nama_instansi}} </option>
				@endforeach
			</select>
			<div id="chartpendonor">
				{!! $chart[3]->render() !!}
			</div>
		</div>
	</div>
@endsection

@section('script')

<script>
$("#pendonor").change(function(){
	var idPendonor = $("#pendonor").val();
	var pendonor = $("#pendonor").find('option:selected').text()
	$.ajax({
		type:'POST',
		url:'chart-pendonor',
		dataType:'json',
		data:{'_token' : '<?php echo csrf_token() ?>',
		'idPendonor': idPendonor},
		success:function(data){
			$('#chartpendonor').hide();
		}
	});
});


</script>
@endsection
