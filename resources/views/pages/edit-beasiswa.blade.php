<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Modifikasi Beasiswa</title>
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
                        <li><a href="./login">log in</a></li>
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
	<form id='createScholarshipForm' action = "./insertScholarship" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
		
		<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
		<input type = "hidden" name = "counter" value="1">
		<div class="form-group">
			<label for="namaBeasiswa">Nama Beasiswa</label>
			<input type="text" class="form-control" name="namaBeasiswa" required="">
		</div>
		<div class="form-group">
			<label for="deskripsiBeasiswa">Deskripsi Beasiswa</label>
			<textarea id="message" class="form-control" name="deskripsiBeasiswa" data-parsley-trigger="keyup" data-parsley-minlength="20"
			data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."s
			data-parsley-validation-threshold="10"></textarea>
		</div>
		<div class="form-group">
			<label for="nominal">Nominal</label>
			<input type="number" class="form-control" name="nominal" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="8" required>
		</div>
		<div class="form-group">
			<label for="totalDana">Total Dana</label>
			<input type="number" class="form-control" name="totalDana" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="20" required>
		</div>
		<div class="form-group">
			<label for="kategoriBeasiswa">Kategori Beasiswa</label>
			<select class="form-control" name="kategoriBeasiswa">
				@foreach ($categories as $category)
				<option value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="tanggalBuka">Tanggal Buka</label>
			<input type="date" name="tanggalBuka" data-date-format="YYYY/MM/DD" required>
		</div>
		<div class="form-group">
			<label for="tanggalTutup">Tanggal Tutup</label>
			<input type="date" name="tanggalTutup" data-date-format="YYYY/MM/DD" required>
		</div>
		<div class="form-group">
		<label for="pendonor">Pendonor</label>
		<select class="form-control" name="pendonor">
			@foreach ($pendonor as $pendonor)
			<option value= {{ $pendonor->id_pendonor}}> {{$pendonor->nama_instansi}} </option>
			@endforeach
		</select>
		</div>

	<div class="form-group">
		<label for="kuota">Kuota</label>
		<input type="number" class="form-control" name="kuota" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
	</div>
	<div class="form-group" name="syarat">
		<label for="syarat">Syarat</label>
		<input type = "text" class="form-control" name="syarat1" required>
	</div>

</form>
<div>
		<button type="button" class="btn btn-default pull-right" id="buttonTambahSyarat" onclick="insertRow()">+</button>
</div>
<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
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
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
<script>
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
			var tanggalBuka = new Date(document.getElementsByName('tanggalBuka')[0].value);
			var tanggalTutup = new Date(document.getElementsByName('tanggalTutup')[0].value);
			if (tanggalBuka.getTime() < tanggalTutup.getTime())
			{
				return true;
			}
			return false;
			//show alert?
	}
	$(function () {
  $('#createScholarshipForm').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
    return false; // Don't submit form for this demo
  });
});


</script>
</body>
</html>
