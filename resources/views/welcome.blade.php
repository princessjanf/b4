@extends('layout')

@section('header')
   {{-- smt --}}
@stop

@section('content')
    <?php 
    use SSO\SSO;
    $cas_path = "../vendor/phpCAS/CAS.php";
    SSO::setCASPath($cas_path);
    SSO::authenticate();
    $user = SSO::getUser(); 
    ?>
<h1>Selamat datang di Modul Beasiswa</h1>
<h1> <?php echo $user->name?> </h1>

@stop

@section('style')
    a:hover:not(.home) {
            color: orange;
    }

    .home {
       background-color: #333333;
       color: #C0C0C0;
    }
@stop