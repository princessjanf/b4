@extends('master')

@section('title', 'Seleksi Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<!-- user : username, name, role
     namarole
     aksestahapan : id_tahapan
     tahapan : id_tahapan, nama_tahapan, nama
-->
<h4>Seleksi {{$beasiswa->nama_beasiswa}}</h4>

<a href = "{{ url('seleksi') }}">  Kembali Ke Daftar Beasiswa  </a>
@if ($check == 1)

	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href = "{{ url('/nama-penerima/'.$idbeasiswa) }}">  Lihat Penerima Beasiswa  </a>

@endif
</br></br></br>s
<table id='tableSeleksi' class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Tahapan</th>
			<th>Nama Penyeleksi</th>
			<th>Jumlah Partisipan Seleksi</th>
			<th>More</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($tahapan as $index => $tahapan)
		<tr>
			<td>{{$index+1}}</td>
			<td>
        {{$tahapan->nama_tahapan}}
			</td>
      <td>
        {{$tahapan->nama}}
      </td>
			<td>
				{{$jumlahpartisipan[$index]}}
			</td>
		  <td>
        @foreach($aksestahapan as $akses)
          @if ($akses->id_tahapan == $tahapan->id_tahapan)
						<a href = "{{ url('seleksi-beasiswa/'.$idbeasiswa.'/'.$tahapan->id_tahapan) }}"> <button> Seleksi </button> </a>
          @endif
        @endforeach
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
  $('#tableSeleksi').DataTable();
});
</script>
@endsection
