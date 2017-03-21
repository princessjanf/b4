<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Detail Beasiswa</title>
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
      </div>

      <div class="col-sm-9">
        @if ($namarole=='Direktorat Kerjasama')
        <h4>Detail Beasiswa <button class="btn"><a href="#upload"><b>Upload</b></a></button></h4>
        @elseif ($namarole=='mahasiswa')
        <h4>Detail Beasiswa <button class="btn"><a href="#daftar"><b>Daftar</b></a></button></h4>
        @else
        <h4>Detail Beasiswa</h4>
        @endif
        <h2>{{$beasiswa->nama_beasiswa}}</h2>
        <p>{{$beasiswa->deskripsi_beasiswa}}</p>
        <p>Periode Beasiswa:  {{$beasiswa->tanggal_buka}} - {{$beasiswa->tanggal_tutup}}</p>
        <p>Persyaratan:
          @if (count($persyaratans) < 1)
          <br>1. -
          @else
          @foreach ($persyaratans as $index => $persyaratan)
          <br>{{$index+1}}. {{$persyaratan->syarat}}
          @endforeach
          @endif
        </p>
        @if ($namarole=='pendonor' && $ispendonor)
        <p>Pendaftar:
          @if (count($pendaftars) < 1)
          <br>1. -
          @else
          @foreach ($pendaftars as $index => $pendaftar)
          <br>{{$index+1}}. {{$pendaftar->nama}}
          @endforeach
          @endif
        </p>
        @endif

        <br>
        <br>
        <br>
        <br>
        <br>

      </div><!--/row-->
      <!-- /upper section -->

      <!-- lower section -->


    </div><!--/container-->
    <!-- /Main -->
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
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
