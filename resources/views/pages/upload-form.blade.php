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
  {{ csrf_field() }}
  Product name:
  <br />
  <input type="text" name="name" />
  <br /><br />
  Product photos (can attach more than one):
  <br />
  <input type="file" name="photos[]" multiple />
  <br /><br />
  <input type="submit" value="Upload" />
</form>

@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
@endsection
