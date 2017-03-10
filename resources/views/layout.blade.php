<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
   
    @yield('header')
	<style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
            position: relative;
        }

        .title {
            font-size: 56px;
        }

        .footer{
            font-size: 8pt;
            color: #C0C0C0;
            background-color: #333333;
            text-align: center;
            padding-top: 1%;
            padding-bottom: 1%;
            position: absolute;
            right: 0;
            left: 0;
            bottom: 0;
            font-family: 'Myriad Pro', sans-serif;
        }

        .navbar{
            color: #C0C0C0;
            background-color: #FCFCFC;
            text-align: center;
            position: absolute;
            right: 0;
            left: 0;
            top: 0;
            font-family: 'Myriad Pro', sans-serif;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #FCFCFC;
             padding-left: 32%;
        }

        li {
            float: left;
            position: relative;
        }

        li a {
            display: inline-block;
            color: black;
            text-align: center;
            padding: 14px 40px;
            text-decoration: none;
        }
        
        @yield('style')
    </style>
</head>
<body>
	 <div class="container">
        <div class="navbar">
            <ul>
              <li><a class="home" href="/">Home</a></li>
              <li><a class="news" href="#news">News</a></li>
              <li><a class="contact" href="#contact">Contact</a></li>
              <li><a class="about" href="about">About</a></li>
              <li><a class="about" href="logout">Klik disini buat logout</a></li>
            </ul>
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            Copyright Team B4 :)
        </div>
    </div>
</body>
</html> 