@extends('master')

@section('title', 'Pendaftar Beasiswa')

@section('content')
<div class="col-sm-9">
    <H2>PENDAFTAR BEASISWA</H2>
    <HR></HR>
    <h3>{{$namaMhs}}</h3>

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
         <tr>
           @foreach($berkas as $index => $file)

            <th><label>{{$index+1}}.</label></th>
           <th><label>{{$file->nama_berkas}}</label></th>

          <form action="{{url ('download-berkas')}}" method="POST">
            <input type="text" value="{{$file->file}}" name="berkas" hidden>
            <input type="hidden" value="<?php echo csrf_token(); ?>" name="_token"> 
           <th><label><button type="submit">{{$file->file}}</button></label></th>
           </form>
         </tr>
            @endforeach
      </tbody>
      
    </table>

    <div>
      <a href="{{ url('pendaftar_beasiswa/' .$mahasiswa->id_user) }}"><button id="cancel" class="btn btn-info" formnovalidate>BACK</button></a>
    </div>

</div>
@endsection

