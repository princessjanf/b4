@extends('master')

@section('title', 'Statistik')

@section('head')
{!! Charts::assets() !!}
@endsection

@section('content')
<br>{!! $chart[0]->render() !!}
<br>{!! $chart[1]->render() !!}
<br>{!! $chart[2]->render() !!}

<table id="tabel" class="table table-striped">
<thead>
	<tr>
		<th>No.</th>
		<th>Nama Beasiswa</th>
		<th>Dana Total</th>
	</tr>
</thead>
<tbody>
<tr>
@foreach($data3 as $index => $data)
<th><label>{{$index+1}}.</label></th>
<th><label>{{$data->nama_beasiswa}}</label></th>
<th><label  id = "index{{$index}}">
	<script>

	var nStr = "{{$data->dana_total}}".toString();
	var x1 = nStr.replace (/,/g, "");

	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}

	document.getElementById("index{{$index}}").innerHTML = "{{$data->nama_mata_uang}} " + x1;

	</script>
	</label></th>
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
		$('#tabel').DataTable();
	});
</script>
@endsection
