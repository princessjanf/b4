@extends('master')

@section('title', 'List beasiswa')

@section('head')
	<link href="{{ asset('css/jquery.dataTables.css')}}" rel="stylesheet" media="screen" />
	<link href="{{ asset('css/dataTables.bootstrap.css')}}" rel="stylesheet" media="screen" />
@endsection

@section('content')
		<div class="col-sm-9">
			@if($namarole!="Pegawai Universitas")
			<h4>List beasiswa</h4>
			@else
			<h4>List beasiswa
			<button id="add-beasiswa" class="btn"><a href="{{url('add-beasiswa')}}"><b>Buat Beasiswa</b></a></button></h4>
			@endif
			<table id="beasiswalist" class="table table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Beasiswa</th>
						<th>Status</th>
						<th>Akhir Periode</th>
						@if($namarole!="Pegawai Fakultas")
						<th>More</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach ($beasiswas as $index => $beasiswa)
					<tr>
						<td>{{$index+1}}</td>
						<td>
							@if ($beasiswa->public == 0)
							<a href="{{url('detail-beasiswa/'.$beasiswa->id_beasiswa)}}">{{$beasiswa->nama_beasiswa}}</a>
							@else
							<a style="font-weight:bold" href="{{url('detail-beasiswa/'.$beasiswa->id_beasiswa)}}">{{$beasiswa->nama_beasiswa}}</a>
							@endif
						</td>
						<td>
							@if ($beasiswa->tanggal_buka <= Carbon\Carbon::now() and Carbon\Carbon::now() <= $beasiswa->tanggal_tutup)
							Dibuka
							@else
							Ditutup
							@endif
						</td>
						<td>{{$beasiswa->tanggal_tutup}}</td>

						<td>
							@if($namarole=="Pegawai Universitas")
							<a href = "{{url('edit-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></button></a>
							<a href = "{{url('delete-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-trash" data-toggle="tooltip" title="Hapus"></i></button></a>
							<a href = "{{url('make-public-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-eye-close" data-toggle="tooltip" title="Make Public"></i></button></a>

							@elseif($namarole=="mahasiswa")
							<a href = "#daftar"><button class="btn"><b>Daftar</b></button></a>
							@elseif($namarole=="Direktorat Kerjasama")
							<style>
								img {
									width: 20px;
								}
							</style>
							<a href = "#upload"><img name = "upload-logo" src="img/upload.png" alt="" /></a>

							@elseif($namarole="pendonor")
							<a href = "{{url('edit-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-pencil" data-toggle="tooltip" title="Edit"></i></button></a>

							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
@endsection

@section('script')
	<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#beasiswalist').DataTable();
		});

		$('#beasiswalist').dataTable( {
			"columnDefs": [
			{ "width": "5%", "targets": 0 },
			{ "width": "40%", "targets": 1 },
			{ "width": "5%", "targets": 2 }
			]
		} );

		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
	</script>
@endsection
