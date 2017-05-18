@extends('master')

@section('title', 'Unggah Dokumen Kerjasama')

@section('content')

@if (count($errors) > 0)
<ul>
  @foreach ($errors->all() as $error)
  <li>{{ $error }}</li>
  @endforeach
</ul>
@endif

<form action="{{url('unggahDK')}}" method="post" enctype="multipart/form-data">
  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
  <input type = "hidden" name = "idDirektorat" value="{{$pengguna->id_user}}" >
  <input type = "hidden" name = "idBeasiswa" value="{{$beasiswa->id_beasiswa}}" >
  <input type = "hidden" name = "namaBeasiswa" value="{{$beasiswa->nama_beasiswa}}" >
  <h3>Unggah Dokumen Kerjasama - {{$beasiswa->nama_beasiswa}} </h3>
  <h6 style="font-weight:bold"><font color="grey">Unggah dokumen kerjasama yang sudah disepakati dalam format .pdf</font></h6>
  <input type="file" class="form-control" name="DokumenKerjasama">
  <br>
  <input type="submit" class="btn btn-info" name="submit" value="Unggah" disabled />
  <a href="{{ url('list-beasiswa') }}"><button type="button" id="kembali" class="btn btn-info" type="button" formnovalidate>Kembali</button></a>
</form>
<br><br>

<br><br><br><br><br>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script type="text/javascript">
$(document).ready(
function(){
    $('input:file').change(
        function(){
            if ($(this).val()) {
                $('input:submit').attr('disabled',false);
                // or, as has been pointed out elsewhere:
                // $('input:submit').removeAttr('disabled');
            }
        }
        );
});
</script>
@endsection
