@extends('master')

@section('title', 'Seleksi Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')

<table id='daftarSeleksi' class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Beasiswa</th>
			<th>More</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($daftarbeasiswa as $index => $beasiswa)
		<tr>
			<td>{{$index+1}}</td>
			<td>
        {{$beasiswa->nama_beasiswa}}
			</td>
      <td>
        		<a href = "{{ url('seleksi/'.$beasiswa->id_beasiswa) }}"> <button> Lihat Tahapan </button> </a>
      </td>
		@endforeach
	</tbody>
</table>

@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
<script>
$(document).ready(function() {
  $('#daftarSeleksi').DataTable();
});
</script>
@endsection
