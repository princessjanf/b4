@extends('master')

@section('title', 'Penerima Beasiswa')

@section('content')

   <div class="col-sm-9">
   <H2>Nama Penerima Beasiswa {{$beasiswa->nama_beasiswa}}</H2>
    @foreach($namapenerima as $index => $penerimaa)
   <p>{{$index+1}}. {{$penerimaa->nama}}</p>
   @endforeach

  <a href = "{{ url('email/' .$beasiswa->id_beasiswa) }}"><button type="button" class="btn btn-info">Kirim Email</button></a>
   </div>
@endsection
