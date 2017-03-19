<!DOCTYPE html>
<html lang="en">


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


  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Daftar Beasiswa</title>
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
    <link href="{{ asset('css/flexslider.css') }}" rel="stylesheet" /><!DOCTYPE html>
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
                         <li><a href="./profile">{{$user->username}} ({{$namarole}})</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="navbar-collapse collapse ">
          <ul class="nav navbar-nav">
            <li><a href="./profile">{{$user->username}} ({{$namarole}})</a></li>
          </ul>
        </div>
      </div>
    </div>

  <!-- script references -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <!-- Main -->
  <div class="container">

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
        </ul>
      </div>

      <div class="col-sm-9">
        <h4>Detail Beasiswa</h4>

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
      </div><!--/row-->
      <!-- /upper section -->

      <!-- lower section -->


    </div><!--/container-->
    <!-- /Main -->


    <!-- script references -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
  </html>