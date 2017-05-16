@extends('master')

@section('title', 'Detail Beasiswa')

@section('content')
@if ($namarole=='Direktorat Kerjasama')
<h4>Detail Beasiswa &nbsp;<a href="#upload"><button class="btn btn-success"><b>Upload</b></button></a></h4>

@elseif ($namarole=='Mahasiswa')
@if ($beasiswa->tanggal_buka <= Carbon\Carbon::now() and Carbon\Carbon::now() <= $beasiswa->tanggal_tutup)
  <h4>Detail Beasiswa &nbsp;</h4>
  <h2>{{$beasiswa->nama_beasiswa}}</h2>
    @if($beasiswa->id_jenis_seleksi=='1')
    <a href= "{{url($beasiswa->link_seleksi)}}"><button class="btn"><b>Daftar</b></button></a>
    @else
    <a href= "{{url('daftar-beasiswa/'.$beasiswa->id_beasiswa)}}"><button class="btn"><b>Daftar</b></button></a>
    @endif
  </h4>
@endif
@elseif ($namarole=="Pegawai Universitas")


<h4>Detail Beasiswa &nbsp;</h4>
<h2>{{$beasiswa->nama_beasiswa}}</h2>
  <a href = "{{ url('edit-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit" role="button">
    <span class="glyphicon glyphicon-pencil"></span>
  </a>
  @if ($beasiswa->public == '0')
  <a href = "{{ url('delete-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-danger" data-toggle="tooltip" title="Hapus" role="button">
    <span class="glyphicon glyphicon-trash"></span>
  </a>
  @endif
  @if ($beasiswa->public == '0')
  <a href = "{{ url('make-public-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info" data-toggle="tooltip" title="Make Public" role="button">
    <span class="glyphicon glyphicon-eye-open"></span>
  </i></button></a>
  @endif
  @if ($isselected == 1)
  		<a href = "{{ url('/nama-penerima/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Penerima Beasiswa  </a>
  @else
  		<a href = "{{ url('/pendaftar-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Pendaftar Beasiswa  </a>
  @endif


@elseif($namarole == 'Pendonor' and $ispendonor)
<h4>Detail Beasiswa &nbsp;</h4>
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
<h4>Detail Beasiswa &nbsp;</h4>
<h2>{{$beasiswa->nama_beasiswa}}</h2>
@if($ispenyeleksi == '1')
@if ($isselected == '1')
    <a href = "{{ url('/nama-penerima/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Penerima Beasiswa  </a>
@else
    <a href = "{{ url('/pendaftar-beasiswa/'.$beasiswa->id_beasiswa) }}" class="btn btn-info">  Lihat Pendaftar Beasiswa  </a>
@endif

@endif



@endif
</br>
</br>
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

<br>
<br>
<br>
<br>
<br>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
@endsection
