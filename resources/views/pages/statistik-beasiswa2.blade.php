@extends('master')

@section('title', 'Statistik')

@section('head')
	{!! Charts::assets() !!}
@endsection

@section('content')
	<div class="col-sm-12">
		{!! $chart->render() !!}
	</div>
</br>
	<select class="col-sm-12"  id='optLihat'>
			<option selected disabled> Lihat Persebaran Jenjang Beasiswa: </option>
			<option value="fakultas"> Lihat Persebaran Fakultas </option>
			<option value="prodi"> Lihat Persebaran Prodi </option>
	</select>
	</br>

	<div id = 'lihatProdi'>

		@for ($i = 0; $i < $countjenjang; $i++)
		<div class="col-sm-12">
			<?php		$var='prodi'.$i; ?>
			{!! $$var->render() !!}
		</div>
	@endfor
	</div>

	<div id='lihatFakultas'>
		<?php $mulai = 0;?>
		@for ($i = 0; $i < $countjenjang; $i++)
		<div class="col-sm-12">
			<?php		$var='fak'.$i;	$index = 0;?>
			{!! $$var->render() !!}
		</div>

		<div class="col-sm-12">
		</br>
		<table id="tabel{{$i}}" class="tabel table table-stripped">
			<thead>
				<tr>
					<th> No </th>
					<th> Nama Prodi </th>
					<th> Jumlah Beasiswa </th>
				</tr>
			</thead>
			<tbody>


				<?php $index = 0;?>
				@for($j = 0; $j < count($namaprodi); $j++)
					@if ($arrjenjang[$j] == $jenjang[$i])
					<tr>
					<td> {{++$index}} </td>
					<td> {{$namaprodi[$j]}} </td>
					<td> {{$jumlahbeasiswa[$j]}} </td>
					</tr>
					@else
					<?php $masuk = $j ?>
					@endif
				@endfor
			</tbody>
		</table>
	</div>
	@endfor
	</div>

@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#tabel0').DataTable();
		$('#tabel1').DataTable();
    $('#tabel2').DataTable();
		$('#tabel3').DataTable();
		$('#tabel4').DataTable();
		$('#tabel5').DataTable();
		$('#tabel6').DataTable();
		$('#tabel7').DataTable();
		$('#tabel8').DataTable();
		$('#tabel9').DataTable();
	});
</script>
<script>
$(document).ready(function(){
	var prev = '';
	$("#lihatFakultas").toggle();
	$("#lihatProdi").toggle();

		$("#optLihat").change(function(){
			var x = $('#optLihat').val();

			if (x == 'fakultas')
			{
					if (prev != '')
						{ $("#lihatProdi").fadeToggle();}
					 $("#lihatFakultas").fadeToggle();
					 prev = x;

			}
			else if (x=='prodi')
			{
				console.log('an');

				if (prev != '')
					{$("#lihatFakultas").fadeToggle();}
					$("#lihatProdi").fadeToggle();
					prev = x;
			}
		});
});
</script>
@endsection
