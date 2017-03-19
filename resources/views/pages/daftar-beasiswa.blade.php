<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Daftar Beasiswa</title>
	<meta name="generator" content="Bootply" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
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

	<!-- Data Table :) -->
	<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
	<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
	<link href="{{ asset('css/jquery.dataTables.css')}}" rel="stylesheet" media="screen" />
	<link href="{{ asset('css/dataTables.bootstrap.css')}}" rel="stylesheet" media="screen" />

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
					<a class="navbar-brand" href="{{url('')}}"><span>M</span>odul Beasiswa</a>
				</div>
				<div class="navbar-collapse collapse ">
					<ul class="nav navbar-nav">
						<li><a href="#profile">{{$user->username}} ({{$namarole}})</a></li>
						<li><a href="{{url('logout')}}">LOG OUT</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<!-- /Header -->

	<!-- Main -->
	<div class="container">

		<!-- upper section -->
		<div class="row">
			<div class="col-sm-3">
				<!-- left -->
				<ul class="nav nav-stacked">
          <li><a href="{{url('')}}">Dashboard</a></li>
          <li><a href="{{url('daftar-beasiswa')}}">Beasiswa</a></li>
          <li><a href="#">LPJ</a></li>
          <li><a href="#">Settings</a></li>
					<hr>
				</ul>
			</div><!-- /span-3 -->
			<div class="col-sm-9">
				<h4>Daftar Beasiswa</h4>
				@if($namarole=="Pegawai Universitas")
				<button id="add-beasiswa"><a href="{{url('add-beasiswa')}}">Buat Beasiswa</a></button>
				<br></br>
				@endif
				<table id="beasiswalist" class="table table-striped">
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
								<a href = "{{url('edit-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-pencil"></i></button></a>
								<a href = "{{url('delete-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-trash"></i></button></a>
								<a href = "{{url('make-public-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-eye-close"></i></button></a>

								@elseif($namarole=="mahasiswa")
								<a href = "#daftar"><button>Daftar</button></a>

								@elseif($namarole=="Direktorat Kerjasama")
								<style>
									img {
										width: 20px;
									}
								</style>
								<a href = "#upload"><img name = "upload-logo" src="img/upload.png" alt="" /></a>

								@elseif($namarole="pendonor")
								<a href = "{{url('edit-beasiswa/'.$beasiswa->id_beasiswa)}}"><button><i class="glyphicon glyphicon-pencil"></i></button></a>

								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div><!--/row-->
		<!-- /upper section -->

		<!-- lower section -->

	</div><!--/container-->
	<!-- /Main -->

	<footer>
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<div class="widget">
						<h5 class="widgetheading">Get in touch with us</h5>
						<address>
							<strong>Moderna company Inc</strong><br>
							Modernbuilding suite V124, AB 01<br>
							Someplace 16425 Earth </address>
							<p>
								<i class="icon-phone"></i> (123) 456-7890 - (123) 555-7891 <br>
								<i class="icon-envelope-alt"></i> email@domainname.com
							</p>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget">
							<h5 class="widgetheading">Pages</h5>
							<ul class="link-list">
								<li><a href="#">Press release</a></li>
								<li><a href="#">Terms and conditions</a></li>
								<li><a href="#">Privacy policy</a></li>
								<li><a href="#">Career center</a></li>
								<li><a href="#">Contact us</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget">
							<h5 class="widgetheading">Latest posts</h5>
							<ul class="link-list">
								<li><a href="#">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a></li>
								<li><a href="#">Pellentesque et pulvinar enim. Quisque at tempor ligula</a></li>
								<li><a href="#">Natus error sit voluptatem accusantium doloremque</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="widget">
							<h5 class="widgetheading">Flickr photostream</h5>
							<div class="flickr_badge">
								<script type="text/javascript" src="https://www.flickr.com/badge_code_v2.gne?count=8&amp;display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=34178660@N03"></script>
							</div>
							<div class="clear">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="sub-footer">
				<div class="container">
					<div class="row">
						<div class="col-lg-6">
							<div class="copyright">
								<p>&copy; Moderna Theme. All right reserved.</p>
								<div class="credits">
									<!--
									All the links in the footer should remain intact.
									You can delete the links only if you purchased the pro version.
									Licensing information: https://bootstrapmade.com/license/
									Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Moderna
								-->
								<a href="https://bootstrapmade.com/">Free Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<ul class="social-network">
							<li><a href="#" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
							<li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
							<li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- script references -->
	{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> --}}
	<script src="js/bootstrap.min.js"></script>
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
	</script>
</body>
</html>
