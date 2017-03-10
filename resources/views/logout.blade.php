@extends('layout')

@section('content')
    <?php
    	use SSO\SSO;
	    $cas_path = "../vendor/phpCAS/CAS.php";
	    SSO::setCASPath($cas_path);
		SSO::logout('localhost/propensi/public');
	?>
@stop

@section('header')
   {{-- smt --}}
@stop

@section('style')
  
@stop