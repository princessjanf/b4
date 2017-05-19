@extends('master')

@section('title', 'Pendaftar Beasiswa')

@section('content')
<div class="col-sm-9">
    <H2>PENDAFTAR BEASISWA</H2>
    <HR></HR>
    <h3>{{$namaMhs->nama}}  </h3>
      <table style="width:75%">
        <tr>
        <th></th>
        <th></th>
        </tr>

        <tr>
          <td>Email</td>
          <td><h5>{{$mahasiswa->email}}</h5></td>
        </tr>
        <tr>
          <td>Fakultas</td>
          <td><h5>{{$fakultas->nama_fakultas}}</h5></td>
        </tr>
        <tr>
          <td>Prodi</td>
          <td><h5>{{$prodi->nama_prodi}}</h5></td>
        </tr>
        <tr>
          <td>IPK</td>
          <td><h5>{{$mahasiswa->IPK}}</h5></td>
        </tr>
        <tr>
          <td>Penghasilan Orang Tua</td>
          <td><h5 id="penghasilan">

            <script>

          	var nStr = "{{$mahasiswa->penghasilan_orang_tua}}".toString();
          	var x1 = nStr.replace (/,/g, "");

          	var rgx = /(\d+)(\d{3})/;
          	while (rgx.test(x1)) {
          		x1 = x1.replace(rgx, '$1' + ',' + '$2');
          	}

          	document.getElementById("penghasilan").innerHTML = "IDR "+ x1;

          	</script>
          </h5></td>
        </tr>
    </table>

    <br>

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
            <input type="hidden" value="{{$namaMhs->username}}" name="username">
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
