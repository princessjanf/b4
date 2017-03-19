@extends('master')

@section('title', 'Daftar Beasiswa')

@section('content')
<h4>Daftar Beasiswa</h4>
@if($namarole=="Pegawai Universitas")
<button id="add-beasiswa"><a href="add-beasiswa">Buat Beasiswa</a></button>
@endif
<table class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Beasiswa</th>
			<th>Status</th>
			<th>Akhir Periode</th>
			@if($namarole=="Pegawai Universitas" || $namarole=="mahasiswa" || $namarole=="Direktorat Kerjasama")
			<th>More</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach ($beasiswas as $index => $beasiswa)
		<tr>
			<td>{{$index+1}}</td>
			<td><a href="detail-beasiswa/{{$beasiswa->id_beasiswa}}">{{$beasiswa->nama_beasiswa}}</a></td>
			<td>
				@if ($beasiswa -> public == 1)
				Dibuka
				@else
				Ditutup
				@endif
			</td>
			<td>{{$beasiswa->tanggal_tutup}}</td>

			<td>
				@if($namarole=="Pegawai Universitas")
				<a href = "edit-beasiswa/{{$beasiswa->id_beasiswa}}"><button><i class="glyphicon glyphicon-pencil"></i></button></a>
				<a href = "delete-beasiswa/{{$beasiswa->id_beasiswa}}"><button><i class="glyphicon glyphicon-trash"></i></button></a>
				<a href = "make-public-beasiswa/{{$beasiswa->id_beasiswa}}"><button><i class="glyphicon glyphicon-eye-close"></i></button></a>

				@elseif($namarole=="mahasiswa")
				<a href = "#daftar"><button>Daftar</button></a>

				@elseif($namarole=="Direktorat Kerjasama")
				<style>
				img {
					width: 20px;
				}
			</style>
			<a href = "#upload"><img name = "upload-logo" src="img/upload.png" alt="" /></a>
			@endif
		</td>
	</tr>
	@endforeach
</tbody>
</table>
@endsection
