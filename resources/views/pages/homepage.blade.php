<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Modul Beasiswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="author" content="http://bootstraptaste.com" />

  <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
  <link href="{{ asset('css/jcarousel.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/flexslider.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  <!-- Theme skin -->
  <link href="{{ asset('skins/default.css') }}" rel="stylesheet" />
</head>
<body>
  <div id="wrapper">
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
              @if($user==null)
              <li class="active"><a href="{{ url('') }}">Beranda</a></li>
              <li><a href="{{ url('login') }}">Masuk</a></li>
              @else
              <li class="active"><a href="{{ url('') }}">Beranda</a></li>
              @if ($namarole=='Pendonor'||$namarole=='Pegawai Universitas'||$namarole=='Pegawai Fakultas')
              <li><a href="#dashboard">Dasbor</a></li>
              @endif
              <li><a href="{{ url('list-beasiswa') }}">Paket-Paket Beasiswa</a></li>
              @if ($namarole=='Pendonor')
              <li><a href="#donate">Donasi</a></li>
							<li><a href="#kelolalpj">Kelola LPJ</a></li>
              @elseif ($namarole=='mahasiswa')
              <li><a href="#isilpj">Isi LPJ</a></li>
              @endif
              <li><a href="{{ url('profil') }}">{{$user->name}} ({{$namarole}})</a></li>
              <li><a href="{{ url('logout') }}">Keluar</a></li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </header>

    <section id="featured">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div id="main-slider" class="flexslider">
              <ul class="slides">
                <li>
                  <img src="{{ asset('img/slides/beasiswa.jpg') }}" alt="">
                  <div class="flex-caption">
                    <h3>Modul Beasiswa Release!</h3>
                    <p>Setelah melewati beberapa tahapan pengembangan aplikasi mulai dari perencanaan, analisis, desain, serta beberapa revisi, akhirnya Modul Beasiswa v1 sudah bisa dinikmati oleh civitas kampus.</p>
                    <a href="#" class="btn btn-theme">Lebih Lanjut</a>
                  </div>
                </li>
                <li>
                  <img src="{{ asset('img/slides/2.jpg') }}" alt="">
                  <div class="flex-caption">
                    <h3>Frequently Asked Question</h3>
                    <p>Ketahui lebih lanjut tentang pertanyaan yang sering ditanyakan oleh pengguna modul beasiswa.</p>
                    <a href="#" class="btn btn-theme">Lebih Lanjut</a>
                  </div>
                </li>
                <li>
                  <img src="{{ asset('img/slides/3.jpg') }}" alt="">
                  <div class="flex-caption">
                    <h3>Download Manual Modul Beasiswa</h3>
                    <p>Ketahui lebih lanjut langkah-langkah resmi dari penggunaan modul beasiswa ini!</p>
                    <a href="#" class="btn btn-theme">Download</a>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="content">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="row">
              @foreach ($beasiswas as $index => $beasiswa)
              <div class="col-lg-3">
                <div class="box">
                  <div class="box-gray aligncenter">
                    <h4>
                      <?php
                      $string = $beasiswa->nama_beasiswa;
                      echo str_limit($string,40);
                      ?>
                    </h4>
                    <div class="icon">
                      <i class="fa fa-desktop fa-3x"></i>
                    </div>
                    <p>
                      <?php
                      $string = $beasiswa->deskripsi_beasiswa;
                      echo str_limit($string,120);
                      ?>
                    </p>
                  </div>
                  <div class="box-bottom">
                    <a href="{{ url('detail-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-theme">Detail</a>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="big-cta">
                <div class="cta-text">
                  <a href="{{ url('list-beasiswa') }}"><h2><span>Lihat</span> Paket-Paket Beasiswa</h2></a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <h4 class="heading">BERITA</h4>
            <div class="row">
              <section id="projects">
                <ul id="thumbs" class="portfolio">
                  <!-- Item Project and Filter Name -->
                  <li class="col-lg-3 design" data-id="id-0" data-type="web">
                    <div class="item-thumbs">
                      <!-- Fancybox - Gallery Enabled - Title - Full Image -->
                      <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="Scholarship Day" href="{{ asset('img/works/1.jpg') }}">
                        <span class="overlay-img"></span>
                        <span class="overlay-img-thumb font-icon-plus"></span>
                      </a>
                      <!-- Thumb Image and Description -->
                      <img src="{{ asset('img/works/1.jpg') }}" alt="Universitas Bakrie mengadakan Scholarship Day yang diadakan pada tanggal 24 Maret 2016 di Universitas Bakrie Jl. HR. Rasuna Said. Info lebih lanjut www.bakrie.ac.id">
                    </div>
                  </li>
                  <!-- End Item Project -->
                  <!-- Item Project and Filter Name -->
                  <li class="item-thumbs col-lg-3 design" data-id="id-1" data-type="icon">
                    <!-- Fancybox - Gallery Enabled - Title - Full Image -->
                    <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="Bakrie Center Foundation" href="{{ asset('img/works/2.jpg') }}">
                      <span class="overlay-img"></span>
                      <span class="overlay-img-thumb font-icon-plus"></span>
                    </a>
                    <!-- Thumb Image and Description -->
                    <img src="{{ asset('img/works/2.jpg') }}" alt="Bakrie Center Foundation membuka beasiswa untuk Master Program (S2). Hadirnya beasiswa ini diharapkan dapat menambah banyak pemimpin-pemimpin baru. Info lebih lanjut klik www.bcf.or.id">
                  </li>
                  <!-- End Item Project -->
                  <!-- Item Project and Filter Name -->
                  <li class="item-thumbs col-lg-3 photography" data-id="id-2" data-type="illustrator">
                    <!-- Fancybox - Gallery Enabled - Title - Full Image -->
                    <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="Beasiswa R-Zis UGM" href="{{ asset('img/works/3.jpg') }}">
                      <span class="overlay-img"></span>
                      <span class="overlay-img-thumb font-icon-plus"></span>
                    </a>
                    <!-- Thumb Image and Description -->
                    <img src="{{ asset('img/works/3.jpg') }}" alt="UGM membuka beasiswa untuk Mahasiswa S1. Beasiswa ditujukkan untuk mahasiswa yang kurang mampu. Info lebih lanjut klik rumahzis.ugm.ac.id">
                  </li>
                  <!-- End Item Project -->
                  <!-- Item Project and Filter Name -->
                  <li class="item-thumbs col-lg-3 photography" data-id="id-2" data-type="illustrator">
                    <!-- Fancybox - Gallery Enabled - Title - Full Image -->
                    <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="Fantasia" href="{{ asset('img/works/4.jpg') }}">
                      <span class="overlay-img"></span>
                      <span class="overlay-img-thumb font-icon-plus"></span>
                    </a>
                    <!-- Thumb Image and Description -->
                    <img src="{{ asset('img/works/4.jpg') }}" alt="Asia Advertising mengadakan kompetisi dengan hadiah beasiswa penuh. Untuk informasi lebih lanjut kunjungi sosial media Fantasia yang tertera di poster">
                  </li>
                  <!-- End Item Project -->
                </ul>
              </section>
            </div>
          </div>
        </div>
      </div>
    </section>

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
  </div>
  <a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
	<!-- script references -->
  <script src="https://code.jquery.com/jquery-3.2.0.slim.min.js" integrity="sha256-qLAv0kBAihcHZLI3fv3WITKeRsUX27hd6upBBa0MSow=" crossorigin="anonymous"></script>
  <script src="js/jquery-3.2.0.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="js/jquery.fancybox.pack.js"></script>
  <script src="js/jquery.fancybox-media.js"></script>
  <script src="js/google-code-prettify/prettify.js"></script>
  <script src="js/portfolio/jquery.quicksand.js"></script>
  <script src="js/portfolio/setting.js"></script>
  <script src="js/jquery.flexslider.js"></script>
  <script src="js/animate.js"></script>
  <script src="js/custom.js"></script>
</body>
</html>
