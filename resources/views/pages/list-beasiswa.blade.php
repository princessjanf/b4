@extends('master')

@section('title', 'List Beasiswa')

@section('content')
@if($namarole=="Pegawai Universitas")
<h4>List beasiswa &nbsp;&nbsp;
	<a data-toggle="tooltip" title="Tambah beasiswa" role="button" id="add-beasiswa" class="btn btn-success" href="{{ url('add-beasiswa') }}"><span class="glyphicon glyphicon-plus">&nbsp;Tambah Beasiswa</span></a>
</h4>
@else
<h4>List beasiswa</h4>
@endif
<table id="beasiswalist" class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Beasiswa</th>
			@if($namarole=="Pendonor" || $namarole=="Pegawai Universitas" || $namarole=="Direktorat Kerjasama")
			<th>Status</th>
			@endif
			<th>Pendaftaran</th>
			<th>Tanggal Tutup</th>
			@if($namarole=="Mahasiswa" || $namarole=="Pegawai Universitas" || $namarole=="Direktorat Kerjasama")
			<th>More</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach ($beasiswas as $index => $beasiswa)
		<tr>
			<td>{{$index+1}}</td>
			<td>
				<a href="{{ url('detail-beasiswa/'.$beasiswa->id_beasiswa) }}">{{$beasiswa->nama_beasiswa}}</a>
			</td>
			@if($namarole=="pendonor" || $namarole=="Pegawai Universitas" || $namarole=="Direktorat Kerjasama")
			<td>
				@if ($beasiswa->public == 1)
				Sudah Publik
				@else
				Belum Publik
				@endif
			</td>
			@endif
			<td>
				@if ($beasiswa->tanggal_buka <= Carbon\Carbon::now() and Carbon\Carbon::now() <= $beasiswa->tanggal_tutup)
				Dibuka
				@else
				Ditutup
				@endif
			</td>
			<td>{{$beasiswa->tanggal_tutup}}</td>

			@if($namarole=="Pegawai Universitas")
			<td>
				<a href = "{{ url('edit-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit" role="button">
					<span class="glyphicon glyphicon-pencil"></span>
				</a>

				<button class="btn btn-danger" type="submit" title="Delete" data-toggle="modal" data-target="#confirmationDelete" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}">
					<span class="glyphicon glyphicon-trash"></span>
				</button>

				<!-- Modal -->
				<div class="modal fade" id="confirmationDelete" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Hapus Beasiswa</h4>
							</div>
							<div class="modal-body">
								<p id='isi'>isinya</p>
							</div>
							<div class="modal-footer">
								<a href="#" id="link" ><button type="button" class="btn btn-success">Ya</button></a>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
							</div>
						</div>
					</div>
				</div>

				<a href = "{{ url('make-public-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info" data-toggle="tooltip" title="Make Public" role="button">
					<span class="glyphicon glyphicon-eye-open"></span>
				</a>
			</td>
			@elseif($namarole=="mahasiswa")
			<td>
				<a href = "{{url('/daftar-beasiswa/'.$beasiswa->id_beasiswa)}}"><button class="btn"><b>Daftar</b></button></a>
			</td>
			@elseif($namarole=="Direktorat Kerjasama")
			<td>
				<a href = "#upload"><img style="width:20px" name = "upload-logo" src="{{ asset('img/upload.png') }}" alt="" /></a>
			</td>
			@endif
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
<script>
	$('#confirmationDelete').on('show.bs.modal', function(e) {
		var idBeasiswa = e.relatedTarget.dataset.username;
		var namaBeasiswa = e.relatedTarget.dataset.username2;
		document.getElementById("isi").innerHTML="Anda yakin ingin menghapus beasiswa "+namaBeasiswa+"?";
		var link = document.getElementById("link");
		var linkHapus = "./delete-beasiswa/"+idBeasiswa;
		link.setAttribute("href", linkHapus);
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#beasiswalist').DataTable();
	});
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<style media="screen">
	.dataTables_filter {
		margin-left: 175px;
	}
</style>
@endsection
