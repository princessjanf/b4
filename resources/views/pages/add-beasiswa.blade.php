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
    <link href='http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css' rel='stylesheet' type='text/css'>
    <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
    <link href='http://davidstutz.github.io/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
    <script src='http://davidstutz.github.io/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>
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
      
    </div><!-- /span-3 -->
    <div class="col-sm-9">
    <h4>Entri Beasiswa</h4>
    <hr>
    <div class='panel-body'>
        <form class='form-horizontal' role='form'>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_accomodation'>Accomodation</label>
            <div class='col-md-2'>
              <select class='form-control' id='id_accomodation'>
                <option>RV</option>
                <option>Tent</option>
                <option>Cabin/Lodging</option>
              </select>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_title'>Name</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                  <select class='form-control' id='id_title'>
                    <option>Mr</option>
                    <option>Ms</option>
                    <option>Mrs</option>
                    <option>Miss</option>
                    <option>Dr</option>
                  </select>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_first_name' placeholder='First Name' type='text'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_last_name' placeholder='Last Name' type='text'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_adults'>Guests</label>
            <div class='col-md-8'>
              <div class='col-md-2'>
                <div class='form-group internal'>
                  <input class='form-control col-md-8' id='id_adults' placeholder='18+ years' type='number'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_children' placeholder='2-17 years' type='number'>
                </div>
              </div>
              <div class='col-md-3 indent-small'>
                <div class='form-group internal'>
                  <input class='form-control' id='id_children_free' placeholder='&lt; 2 years' type='number'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_email'>Contact</label>
            <div class='col-md-6'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='id_email' placeholder='E-mail' type='text'>
                </div>
              </div>
              <div class='form-group internal'>
                <div class='col-md-11'>
                  <input class='form-control' id='id_phone' placeholder='Phone: (xxx) - xxx xxxx' type='text'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_checkin'>Checkin</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' id='id_checkin'>
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
              <label class='control-label col-md-2' for='id_checkout'>Checkout</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' id='id_checkout'>
                  <span class='input-group-addon'>
                    <i class='glyphicon glyphicon-calendar'></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>Equipment type</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal'>
                  <select class='form-control' id='id_equipment'>
                    <option>Travel trailer</option>
                    <option>Fifth wheel</option>
                    <option>RV/Motorhome</option>
                    <option>Tent trailer</option>
                    <option>Pickup camper</option>
                    <option>Camper van</option>
                  </select>
                </div>
              </div>
              <div class='col-md-9'>
                <div class='form-group internal'>
                  <label class='control-label col-md-3' for='id_slide'>Slide-outs</label>
                  <div class='make-switch' data-off-label='NO' data-on-label='YES' id='id_slide_switch'>
                    <input id='id_slide' type='checkbox' value='chk_hydro'>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_service'>Required Service</label>
            <div class='col-md-8'>
              <select class='multiselect' id='id_service' multiple='multiple'>
                <option value='hydro'>Hydro</option>
                <option value='water'>Water</option>
                <option value='sewer'>Sewer</option>
              </select>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_pets'>Pets</label>
            <div class='col-md-8'>
              <div class='make-switch' data-off-label='NO' data-on-label='YES' id='id_pets_switch'>
                <input id='id_pets' type='checkbox' value='chk_hydro'>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_comments'>Comments</label>
            <div class='col-md-6'>
              <textarea class='form-control' id='id_comments' placeholder='Additional comments' rows='3'></textarea>
            </div>
          </div>
          <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-primary' type='submit'>Request Reservation</button>
            </div>
            <div class='col-md-3'>
              <button class='btn-lg btn-danger' style='float:right' type='submit'>Cancel</button>
            </div>
          </div>
        </form>
      </div>
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