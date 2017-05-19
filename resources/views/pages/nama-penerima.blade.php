@extends('master')

@section('title', 'Penerima Beasiswa')

@section('content')

   <div class="col-sm-9">
     <H2>Nama Penerima Beasiswa {{$beasiswa->nama_beasiswa}}</H2>
      @foreach($namapenerima as $index => $penerimaa)
       <p>{{$index+1}}. {{$penerimaa->nama}}</p>
      @endforeach

      @if(@$status->is_emailed == '1')
        <a href = "{{ url('email/' .$beasiswa->id_beasiswa) }}"><button disabled type="button" class="btn btn-info" style="display: none;">Kirim Email</button></a>
<br>
    <b>  Email telah dikirim kepada para pendaftar. </b>
      @else
        <a href = "{{ url('email/' .$beasiswa->id_beasiswa) }}"><button type="button" class="btn btn-info">Kirim Email</button></a>
      @endif
   </div>
@endsection
