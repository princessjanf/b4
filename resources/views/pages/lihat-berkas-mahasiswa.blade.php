@extends('master')

@section('title', 'Pendaftar Beasiswa')

@section('content')
<div class="col-sm-9">
    <H2>PENDAFTAR BEASISWA</H2>
    <HR></HR>
    <h3>{{$namaMhs->nama}}</h3>

    <p>BERKAS YANG DIMILIKI MAHASISWA</p>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama Berkas</th>
          <th>File</th>
        </tr>
      </thead>

      <tbody>
        @if (count($berkas)==0)
        <tr>
        <th><label>1. </label></th>
        <th>-</th>
        <th>-</th>

      </tr>
        @else
           @foreach($berkas as $index => $file)
           <tr>

            <th><label>{{$index+1}}.</label></th>
           <th><label>{{$file->nama_berkas}}</label></th>

          <form action="{{url ('download-berkas')}}" method="POST">
            <input type="text" value="{{$file->file}}" name="berkas" hidden>
            <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token">
           <th><label><button type="submit" class="btn btn-default">Download</button></label></th>
           </form>
         </tr>
            @endforeach
            @endif
      </tbody>

    </table>

    <div>
      <a href="{{ url('pendaftar-beasiswa/' .$beasiswa->id_beasiswa) }}"><button id="cancel" class="btn btn-info" type="button" formnovalidate>BACK</button></a>
    </div>

</div>
@endsection
