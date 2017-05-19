@extends('master')

@section('title', 'Seleksi Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<h2>DAFTAR BEASISWA YANG DAPAT DISELEKSI</h2>
<table id='daftarSeleksi' class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Beasiswa</th>
			<th>Jumlah Pendaftar</th>
			<th>More</th>
		</tr>
	</thead>
	<tbody>

		@foreach ($daftarbeasiswa as $index => $beasiswa)
		@if ($beasiswa->id_jenis_seleksi == 1)
			@continue
		@else
		<tr>

			<td>{{$index + 1}}</td>
			<td>
        {{$beasiswa->nama_beasiswa}}
			</td>
			<td>
				{{$jumlahpendaftar[$index]}}
			</td>
      <td>
						@if($beasiswa->id_jenis_seleksi == '2')
							<a href = "{{ url('seleksi-luar/'.$beasiswa->id_beasiswa) }}"> Penilaian </a>
						@elseif($beasiswa->id_jenis_seleksi == '3')
							<a href = "{{ url('seleksi/'.$beasiswa->id_beasiswa) }}"> Lihat Tahapan </a>
						@endif
      </td>
			@endif
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
