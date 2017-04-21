@extends('master')

@section('title', 'Detail Beasiswa')

@section('content')

@if (count($errors) > 0)
<ul>
  @foreach ($errors->all() as $error)
  <li>{{ $error }}</li>
  @endforeach
</ul>
@endif

<form action="{{url('upload')}}" method="post" enctype="multipart/form-data">
  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
  <input type = "hidden" name = "idBeasiswa" value="1" >
  <input type = "hidden" name = "idBerkas" value="1" >
  <input type = "hidden" name = "idMahasiswa" value="2" >

  1. Judulnya:
  <input type = "hidden" name = "nama[0]" value="Judulnya" >
  <input type="file" name="berkases[0]" />
  <br>
  2. Judulnya2:
  <input type = "hidden" name = "nama[1]" value="Judulnya2" >
  <input type="file" name="berkases[1]" />
  <br><br>
  <input type="submit" name="submit" value="Upload" />
</form>

@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
@endsection
