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
			<h4>List beasiswa</h4>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a data-toggle="tooltip" title="Tambah beasiswa" role="button" id="add-beasiswa" class="btn btn-success" href="{{url('add-beasiswa')}}"><span class="glyphicon glyphicon-plus">&nbsp;Tambah Beasiswa</span>
				</a>
			
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
							<a href = "{{url('edit-beasiswa/'.$beasiswa->id_beasiswa)}}" class="btn btn-warning" data-toggle="tooltip" title="Edit" role="button"">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>


							<button class="btn btn-danger" type="submit" data-toggle="modal" data-target="#confirmationModal" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}">
								<span class="glyphicon glyphicon-trash"></span>
							</button>

							<!-- Modal -->
								  <div class="modal fade" id="confirmationModal" role="dialog">
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

							<a href = "{{url('make-public-beasiswa/'.$beasiswa->id_beasiswa)}}" class="btn btn-info" data-toggle="tooltip" title="Make Public" role="button"">
								<span class="glyphicon glyphicon-eye-open"></span>
							</a>

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
							
								<a href = "{{url('edit-beasiswa/'.$beasiswa->id_beasiswa)}}" class="btn btn-warning" data-toggle="tooltip" title="Edit" role="button"">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>
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
	<script>
	$('#confirmationModal').on('show.bs.modal', function(e) {
          var idBeasiswa = e.relatedTarget.dataset.username;
          var namaBeasiswa = e.relatedTarget.dataset.username2;
          document.getElementById("isi").innerHTML="Anda yakin ingin menghapus beasiswa "+namaBeasiswa+ " ?";
          var link = document.getElementById("link");
          var linkHapus = "./delete-beasiswa/"+idBeasiswa;
        link.setAttribute("href", linkHapus);
      });	
	</script>
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