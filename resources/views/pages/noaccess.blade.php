<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Acces Denied!</title>
	<meta name="generator" content="Bootply" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
	<link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
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
		<style>
			img {
				display: block;
				margin: auto;
				width: 35%;
			}
		</style>
		<img src="http://www.clker.com/cliparts/a/K/l/k/C/w/light-blue-warning-sign-hi.png"  width="70">
		<h1 style="text-align:center;"> Maaf, Anda tidak memiliki akses ke halaman ini </h1>
		<h3 style="text-align:center;"> <a href="{{url('homepage')}}"> Kembali ke Homepage </a></h3>
		<!--/container-->
	</div>
	<!-- /Main -->

	<footer>
		<div class="container">
			<div class="row">
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
										<p>Modul Beasiswa created by Propensi B4</p>
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
			</div>
		</div>
	</footer>

	<!-- script references -->
	<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
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
