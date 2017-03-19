<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Buat Entri Beasiswa</title>
	<meta name="generator" content="Bootply" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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
					<a class="navbar-brand" href="."><span>M</span>odul Beasiswa</a>
				</div>
				<div class="navbar-collapse collapse ">
					<ul class="nav navbar-nav">
						<li><a href="#profile">{{$user->username}} ({{$namarole}})</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>
	<!-- /Header -->

	<!-- Main -->
	<!-- upper section -->
	<div class="row">
		<div class="col-sm-3">
			<!-- left -->
			<ul class="nav nav-stacked">
				<li><a href="./homepage">Dashboard</a></li>
				<li><a href="./daftar-beasiswa">Beasiswa</a></li>
				<li><a href="http://www.bootply.com/85861">LPJ</a></li>
				<li><a href="http://www.bootply.com/85861">Settings</a></li>
				<hr>

			</div><!-- /span-3 -->
			<div class="col-sm-9">
				<form id='createScholarshipForm' action = "./insert-beasiswa" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
					<div>
						<h3> Informasi Beasiswa </h3>
					</div>
					<div>
						<button type="submit" id="submit-form"> Submit </button>
					</div>
					<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
					<input type = "hidden" name = "counter" value="1">

					<div class="form-group">
						<label for="namaBeasiswa">Nama Beasiswa</label>
						<input type="text" placeholder="Nama Beasiswa" class="form-control" name="namaBeasiswa" required="">
					</div>

					<div class="form-group">
						<label for="deskripsiBeasiswa">Deskripsi Beasiswa</label>
						<textarea id="message" placeholder="Deskripsi Beasiswa" class="form-control" name="deskripsiBeasiswa" data-parsley-trigger="keyup" data-parsley-minlength="20"
						data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."s
						data-parsley-validation-threshold="10"></textarea>
					</div>
					<div class = "row">
						<div class="form-group col-sm-6">
							<label for="pendonor">Pendonor</label>
							<select class="form-control" name="pendonor">
								@foreach ($pendonor as $pendonor)
								<option value= {{ $pendonor->id_pendonor}}> {{$pendonor->nama_instansi}} </option>
								@endforeach
							</select>
						</div>

						<div class="form-group col-sm-3">
							<label for="kuota">Kuota (Mahasiswa)</label>
							<input type="number" placeholder="125" class="form-control" name="kuota" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
						</div>

					</div>
					<div class = "row">
						<div class="form-group col-sm-2">
							<label for="kategoriBeasiswa">Kategori Beasiswa</label>
							<select class="form-control" name="kategoriBeasiswa">
								@foreach ($kategoribeasiswa as $category)
								<option value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-sm-3">
							<label for="jenjangBeasiswa">Untuk Jenjang</label>
							<select class="form-control" name="jenjangBeasiswa">
								@foreach ($jenjang as $jenjangbeasiswa)
								<option value= {{ $jenjangbeasiswa->id_jenjang}}> {{$jenjangbeasiswa->nama_jenjang}} </option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-sm-4">
							<label for="fakultasBeasiswa">Fakultas Beasiswa</label>
							<select class="form-control" name="fakultasBeasiswa">
								@foreach ($fakultasbeasiswa as $fakultas)
								<option value= {{ $fakultas->id_fakultas}}> {{$fakultas->nama_fakultas}} </option>
								@endforeach
							</select>
						</div>
					</div>
					<div class = "row">
						<div class="form-group col-sm-5">
							<label for="totalDana">Total Dana</label>
							<p> Total dana yang akan diberikan ke universitas </p>
							<input type="number" class="form-control" name="totalDana" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="20" required>
						</div>
						<div class="form-group col-sm-4">
							<label for="periode">Periode</label>
							<p> Periode beasiswa diberikan </p>
							<input type="number" class="form-control" placeholder="2016.1 - 2017.4" name="periode" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="8" required>
						</div>
					</div>
					<div class = "row">
						<div class="form-group col-sm-5">
							<label for="nominal">Nominal</label>
							<p> Dana yang akan diberikan kepada  mahasiswa </p>
							<input type="number" class="form-control" name="nominal" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="8" required>
						</div>

						<div class="form-group col-sm-4">
							<label for="jangka">Jangka (Semester) </label>
							<p> Jangka waktu pemberian beasiswa </p>
							<input type="number" placeholder="4 (4 Semester)" class="form-control" name="jangka" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
						</div>
					</div>
					<div class = "row">

						<div class="form-group col-sm-4">
							<label for="tanggalBuka">Tanggal Buka</label>
							<input type="date" name="tanggalBuka" data-date-format="YYYY/MM/DD" required>
						</div>
						<div class="form-group col-sm-4">
							<label for="tanggalTutup">Tanggal Tutup</label>
							<input type="date" name="tanggalTutup" data-date-format="YYYY/MM/DD" required>
						</div>

					</div>

					<div class="row">
						<label for="syarat">Syarat</label>
						<div class="button">
							<button type="button" class="btn btn-default" id="buttonTambahSyarat" onclick="insertRow()">+</button>
						</div>
						<div class="form-group" name="syarat">
							<input type = "text" class="form-control" name="syarat1" required>
						</div>
					</div>

				</form>


				<div name= "alertDanaModal" class="alert alert-danger alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Jumlah total dana harus sama dengan jumlah kuota x nominal x jangka</strong>
				</div>

				<div name= "alertDateModal" class="alert alert-danger alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Tanggal Tutup Harus Lebih Besar Dari Tanggal Buka</strong>
				</div>

			</div>

		</div>


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


		<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
		<script src="http://parsleyjs.org/dist/parsley.js"></script>
		<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
		<script>
			$("[name='alertDateModal']").hide();
			$("[name='alertDanaModal']").hide();
			counter=1;
			function insertRow(){
				counter+=1;
				document.getElementsByName("counter")[0].value = counter;
				var theForm = document.getElementById('createScholarshipForm');
				/*
				var tmp = document.createElement("input");
				tmp.name = "syarat"+counter;
				tmp.type = "text";
				console.log(tmp.name);
				theForm.appendChild(tmp);
				var r = document.createElement('span');
				theForm.appendChild(r);
				*/
				var x = document.getElementsByName('syarat')[0];
				var elem = document.createElement('div');
				elem.innerHTML = '<input type = "text" class="form-control" name="syarat'+counter+'">';
				x.appendChild(elem);
				theForm.appendChild(x);
			}

			function validateForm(){
				var totalDana = document.getElementsByName('totalDana')[0].value;
				var kuota = document.getElementsByName('kuota')[0].value;
				var nominal = document.getElementsByName('nominal')[0].value;
				var jangka = document.getElementsByName('jangka')[0].value;
				var jumlahDana = kuota*nominal*jangka;
				var tanggalBuka = new Date(document.getElementsByName('tanggalBuka')[0].value);
				var tanggalTutup = new Date(document.getElementsByName('tanggalTutup')[0].value);
				if (tanggalBuka.getTime() < tanggalTutup.getTime() && totalDana == kuota*nominal*jangka)
				{
					return true;
				}
				else if(totalDana != jumlahDana){
					$("[name='alertDanaModal']").show();
					return false;
				}
				else{
					$("[name='alertDateModal']").show();
					return false;
				}

			}
			$(function () {
				$('#createScholarshipForm').parsley().on('field:validated', function() {
					var ok = $('.parsley-error').length === 0;
					$('.bs-callout-info').toggleClass('hidden', !ok);
					$('.bs-callout-warning').toggleClass('hidden', ok);
				})
				.on('form:submit', function() {
					return true;
				});
			});

		</script>

	</body>
	</html>
