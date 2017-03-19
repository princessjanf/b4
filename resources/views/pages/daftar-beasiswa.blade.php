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
                            <li><a href="./logout">LOG OUT</a></li>
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
					<li><a href="./homepage">Dashboard</a></li>
					<li><a href="./daftar-beasiswa">Beasiswa</a></li>
					<li><a href="http://www.bootply.com/85861">LPJ</a></li>
					<li><a href="http://www.bootply.com/85861">Settings</a></li>
					<hr>
				</ul>
			</div><!-- /span-3 -->

    <div class="col-sm-9">
    <h4>Daftar Beasiswa</h4>
    @if($namarole=="Pegawai Universitas")
    <button id="add-beasiswa"><a href="add-beasiswa">Buat Beasiswa</a></button>
    @endif
    <table class="table table-striped">
        <thead>
          <tr>
						<th>No</th>
						<th>Nama Beasiswa</th>
						<th>Status</th>
						<th>Akhir Periode</th>
						<th>More</th>
					</tr>
        </thead>
        <tbody>
					@foreach ($beasiswas as $index => $beasiswa)
    				  <tr>
								<td>{{$index+1}}</td>
								<td>{{$beasiswa->nama_beasiswa}}</td>
								<td>
									@if ($beasiswa -> flag == 1)
										Dibuka
									@else
										Ditutup
									@endif
								</td>
								<td>{{$beasiswa->tanggal_tutup}}</td>
		          	<td>           
                                    @if($namarole=="Pegawai Universitas")
    									<a href = "./daftar-beasiswa"><button><i class="glyphicon glyphicon-pencil"></i></button></a>

    									 <!-- Trigger/Open The Modal -->
										<button id="myBtn"><i class="glyphicon glyphicon-trash"></i></button></button>



                                        <style>
                                        /* The Modal (background) */
										.modal {
										    display: none; /* Hidden by default */
										    position: fixed; /* Stay in place */
										    z-index: 1; /* Sit on top */
										    left: 0;
										    top: 0;
										    width: 100%; /* Full width */
										    height: 100%; /* Full height */
										    overflow: auto; /* Enable scroll if needed */
										    background-color: rgb(0,0,0); /* Fallback color */
										    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
										}

										/* Modal Content/Box */
										.modal-content {
										    background-color: #fefefe;
										    margin: 15% auto; /* 15% from the top and centered */
										    padding: 20px;
										    border: 1px solid #888;
										    width: 80%; /* Could be more or less, depending on screen size */
										}

										/* The Close Button */
										.close {
										    color: #aaa;
										    float: right;
										    font-size: 28px;
										    font-weight: bold;
										}

										.close:hover,
										.close:focus {
										    color: black;
										    text-decoration: none;
										    cursor: pointer;
										}	
                                        </style>

                                       

										<!-- The Modal -->
										<div id="myModal" class="modal">

										  <!-- Modal content -->
										  <div class="modal-content">
										    <span class="close">&times;</span>
										    <p>Are you sure want to delete this beasiswa?</p>
										    <button id="yes-button-delete" class="btn btn-success">Yes</button>
										    <button id="no-button-delete" class="btn btn-danger">No</button>
										  </div>

										</div>

										<script>
										// Get the modal
										var modal = document.getElementById('myModal');

										// Get the button that opens the modal
										var btn = document.getElementById("myBtn");

										// Get the <span> element that closes the modal
										var span = document.getElementsByClassName("close")[0];

										// When the user clicks the button, open the modal 
										btn.onclick = function() {
										    modal.style.display = "block";
										}

										// When the user clicks on <span> (x), close the modal
										span.onclick = function() {
										    modal.style.display = "none";
										}

										// When the user clicks anywhere outside of the modal, close it
										window.onclick = function(event) {
										    if (event.target == modal) {
										        modal.style.display = "none";
										    }
										}
										</script>



                                        <a href = "./#"><button><i class="glyphicon glyphicon-eye-close"></i></button></a>
                                    
                                    @elseif($namarole=="mahasiswa")
                                        <a href = "#"><button>Apply</button></a>
                                    
                                    @elseif($namarole=="Direktorat Kerjasama")
                                    <style>
                                    	img {
										    width: 20px;
										}
									</style>
                                        <a href = "#"><img name = "upload-logo" src="img/upload.png" alt="" /></a>

                                    @else

                                    <p>-</p>

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
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
