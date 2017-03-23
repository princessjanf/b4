<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>@yield('title')</title>
	<meta name="generator" content="Bootply" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jcarousel.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/flexslider.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/parsley.css') }}" rel="stylesheet" />
	<!-- Theme skin -->
	<link href="{{ asset('skins/default.css') }}" rel="stylesheet" />
	@yield('head')
</head>
<body>
	<!-- Header -->
	<header>
		<div class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{url('')}}"><span><img src="{{ asset('img/logo.png') }}" alt="Logo" style="width:80px;height:60px;">M</span>odul Beasiswa</a>
				</div>
				<div class="navbar-collapse collapse ">
					<ul class="nav navbar-nav">
						<li><a href="{{url('')}}">Home</a></li>
						<li><a href="#profile">{{$user->username}} ({{$namarole}})</a></li>
						<li><a href="{{url('logout')}}">LOG OUT</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<!-- /Header -->

	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<ul class="nav nav-stacked">
					<hr>
					<li><a href="#dashboard">Dashboard</a></li>
					<li><a href="{{url('list-beasiswa')}}">List Beasiswa</a></li>
					<li><a href="#lpj">Kelola LPJ</a></li>
					<li><a href="#settings">Settings</a></li>
					<hr>
				</ul>
			</div>
			<div class="col-sm-9">
				@if($namarole!="Pegawai Universitas")
				<h4>List beasiswa</h4>
				@else
				<h4>List beasiswa
				&nbsp;&nbsp;
				<a data-toggle="tooltip" title="Tambah beasiswa" role="button" id="add-beasiswa" class="btn btn-success" href="{{url('add-beasiswa')}}"><span class="glyphicon glyphicon-plus">&nbsp;Tambah Beasiswa</span>
				</a></h4>

				@endif
				<table id="beasiswalist" class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Beasiswa</th>
							<th>Status</th>
							<th>Akhir Periode</th>
							@if($namarole=="Pegawai Universitas" || $namarole=="Pegawai Universitas" || $namarole=="Direktorat Kerjasama")
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

								@if($namarole=="Pegawai Universitas")
								<td>
								<a href = "{{url('edit-beasiswa/'.$beasiswa->id_beasiswa)}}" class="btn btn-warning" data-toggle="tooltip" title="Edit" role="button">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>


								<!-- <button class="btn btn-danger" value="{{$beasiswa->id_beasiswa}}" type="submit" data-toggle="modal" data-target="#confirmationModal" data-username="{{$beasiswa->id_beasiswa}}" data-username2="{{$beasiswa->nama_beasiswa}}">
									<span class="glyphicon glyphicon-trash"></span>
								</button> -->

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
			                  <p id='isi'></p>
			                </div>
			                <div class="modal-footer">
			                  <a href="#" id="link" ><button type="button" class="btn btn-success">Ya</button></a>
			                 <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
			                </div>
			              </div>

			            </div>
			          </div>

								<a href = "{{url('make-public-beasiswa/'.$beasiswa->id_beasiswa)}}" class="btn btn-info" data-toggle="tooltip" title="Make Public" role="button">
									<span class="glyphicon glyphicon-eye-open"></span>
								</a>
								</td>
								@elseif($namarole=="mahasiswa")
								<td>
								<a href = "#daftar"><button class="btn"><b>Daftar</b></button></a>
								</td>
								@elseif($namarole=="Direktorat Kerjasama")
								<style>
									img {
										width: 20px;
									}
								</style>
								<td>
								<a href = "#upload"><img name = "upload-logo" src="img/upload.png" alt="" /></a>
							</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
	<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
	<script>
 $('#confirmationDelete').on('show.bs.modal', function(e) {
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
	<style media="screen">
	.dataTables_filter {
		margin-left: 175px;
	}
	</style>
</body>
</html>
