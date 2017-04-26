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
	<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/parsley.css') }}" rel="stylesheet" />
	<!-- Theme skin -->
	<link href="{{ asset('skins/default.css') }}" rel="stylesheet" />
	@yield('head')
</head>
<body>
	<header>
		<div class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ url('') }}"><span><img src="{{ asset('img/logo.png') }}" alt="Logo" style="width:80px;height:60px;">M</span>odul Beasiswa</a>
				</div>
				<div class="navbar-collapse collapse ">
					<ul class="nav navbar-nav">
						<li><a href="{{ url('profil') }}">{{$user->username}} ({{$namarole}})</a></li>
						<li><a href="{{ url('logout') }}">LOG OUT</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>

	<div class="container">
		<div class="row">
			<div class="col-sm-3" id=sidebar>
				<ul class="nav nav-stacked">
					<hr>
					<li><a href="{{ url('') }}">Home</a></li>
					@if ($namarole=='pendonor'||$namarole=='Pegawai Universitas'||$namarole=='Pegawai Fakultas')
					<li><a href="#dashboard">Dashboard</a></li>
					@endif
					<li><a href="{{ url('list-beasiswa') }}">List Beasiswa</a></li>
					@if ($namarole=='pendonor')
					<li><a href="#kelolalpj">Kelola LPJ</a></li>
					@elseif ($namarole=='Mahasiswa')
					<li><a href="#isilpj">Isi LPJ</a></li>
					@endif
					<li><a href="#settings">Settings</a></li>
					<hr>
				</ul>
			</div>
	    <div class="col-sm-9">
				@yield('content')
			</div>
		</div>
	</div>

	<footer>
		<div class="container">
			<div class="row">
				<div id="sub-footer">
					<div class="container">
						<div class="row">
							<div class="col-lg-6">
								<div class="copyright">
									<p>&copy; 2017 Copyright Kelompok B4</p>
									<div class="credits">
										<p>Modul Beasiswa created by Propensi B4</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<ul class="social-network">
									<li><a href="#" data-placement="top" title="Facebooook"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
									<li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- script references -->
	@yield('script')
</body>
</html>
