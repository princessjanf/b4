@extends('master')

@section('title', 'Detail Beasiswa')

@section('content')

@if (session('namabeasiswa'))
    <div class="alert alert-success">
        {{ session('namabeasiswa') }} telah <b> berhasil </b> dibuat!
    </div>

@elseif (session('namabeasiswamodif'))
    <div class="alert alert-success">
        {{ session('namabeasiswamodif') }} telah <b> berhasil </b> dimodifikasi!
    </div>

@elseif (session('namabeasiswadaftar'))
    <div class="alert alert-success">
        Anda telah <b> berhasil </b> mendaftar ke {{ session('namabeasiswadaftar') }}! 
    </div>

@endif

@if ($namarole=='Direktorat Kerjasama')

<h4>Detail Beasiswa</h4>
<h2>{{$beasiswa->nama_beasiswa}}</h2>

@elseif ($namarole=='Mahasiswa')

  @if ($beasiswa->tanggal_buka <= Carbon\Carbon::now() and Carbon\Carbon::now() <= $beasiswa->tanggal_tutup)
    <h4>DETAIL BEASISWA &nbsp;
      @if($beasiswa->id_jenis_seleksi=='1')
      <a href= "{{url($beasiswa->link_seleksi)}}"><button class="btn"><b>Daftar</b></button></a>
      @else
      <a href= "{{url('daftar-beasiswa/'.$beasiswa->id_beasiswa)}}"><button class="btn"><b>Daftar</b></button></a>
      @endif
    </h4>
    <h2>{{$beasiswa->nama_beasiswa}}</h2>
  @else
    <h4>DETAIL BEASISWA &nbsp;</h4>
    <h2>{{$beasiswa->nama_beasiswa}}</h2>
  @endif
@elseif ($namarole=="Pegawai Universitas")

<h4>DETAIL BEASISWA &nbsp;</h4>
<h2>{{$beasiswa->nama_beasiswa}}</h2>
  @if ($isselected == 1)
  		<a href = "{{ url('/nama-penerima/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Penerima Beasiswa  </a>
  @else
  		<a href = "{{ url('/pendaftar-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Pendaftar Beasiswa  </a>
  @endif
  <br><br>

@elseif($namarole == 'Pendonor' and $ispendonor)
<h4>DETAIL BEASISWA &nbsp;</h4>
<h2>{{$beasiswa->nama_beasiswa}}</h2>
  @if ($isselected == 1)
      <a href = "{{ url('/nama-penerima/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Penerima Beasiswa  </a>
  @else
      <a href = "{{ url('/pendaftar-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Pendaftar Beasiswa  </a>
  @endif
  @if($ispenyeleksi == '1')
    @if ($isselected == '1')
      <a href = "{{ url('/nama-penerima/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Penerima Beasiswa  </a>
    @else
      <a href = "{{ url('/pendaftar-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Pendaftar Beasiswa  </a>
    @endif
  @endif
@else
  <h4>DETAIL BEASISWA &nbsp;</h4>
  <h2>{{$beasiswa->nama_beasiswa}}</h2>
  @if($ispenyeleksi == '1')
    @if ($isselected == '1')
        <a href = "{{ url('/nama-penerima/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Penerima Beasiswa  </a>
    @else
        <a href = "{{ url('/pendaftar-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Pendaftar Beasiswa  </a>
    @endif
  @endif
@endif
<p>{{$beasiswa->deskripsi_beasiswa}}</p>
<p><b>Kategori Beasiswa:</b> {{$kategori->nama_kategori}}</p>
<p><b>Kuota:</b> {{$beasiswa->kuota}}</p>
<p><b>Dana Pendidikan:</b> Rp.{{$beasiswa->dana_pendidikan}}</p>
<p><b>Dana Hidup:</b> Rp.{{$beasiswa->dana_hidup}}</p>
<p><b>Periode Pendaftaran Beasiswa</b>:  {{$beasiswa->tanggal_buka}} s/d {{$beasiswa->tanggal_tutup}}</p>
<p><b>Persyaratan</b>:
  @if (count($persyaratans) < 1)
  <br>1. -
  @else
  @foreach ($persyaratans as $index => $persyaratan)
  <br>{{$index+1}}. {{$persyaratan->syarat}}
  @endforeach
  @endif
</p>
@if ($namarole=='Pendonor' && $ispendonor)
<p><b>Pendaftar</b>:
  @if (count($pendaftars) < 1)
  <br>1. -
  @else
  @foreach ($pendaftars as $index => $pendaftar)
  <br>{{$index+1}}. {{$pendaftar->nama}}
  @endforeach
  @endif
</p>
@endif
<a href="{{ url('list-beasiswa') }}"><button type="button" id="kembali" class="btn btn-info" type="button" formnovalidate>Kembali</button></a>
</br></br></br></br></br></br></br></br></br>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
@endsection
