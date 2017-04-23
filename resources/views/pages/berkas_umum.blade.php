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
  <input type = "hidden" name = "idMahasiswa" value={{$pengguna->id_user}} >

  <div class="row">
    <h5>Berkas:</h5>
    @foreach ($berkas as $index => $tmp)
    <input name = "nama[{{$index}}]" value="{{$tmp->nama_berkas}}" hidden>
    <input name = "idBerkas[{{$index}}]" value="{{$tmp->id_berkas}}" hidden>
    <div class="form-group col-sm-7">
      <label for="berkases[{{$index}}]">{{$index+1}}. {{$tmp->nama_berkas}}</label>
      <input type="file" class="form-control" name="berkases[{{$index}}]">
    </div>
    @endforeach
  </div>
  <input class="btn" type="submit" name="submit" value="Upload" />
</form>

@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
@endsection
