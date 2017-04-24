@extends('master')

@section('title', 'Daftar Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<form id='daftarScholarshipForm' action = "{{ url('register-beasiswa') }}" onsubmit="return validateForm()" method = "post" data-parsley-validate="" enctype="multipart/form-data">
	<div>
		<h3> Daftar Beasiswa </h3> <h4><font color="#003366"> {{$beasiswa->nama_beasiswa}}</font></h4>
		<hr>
	</div>

	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
	<input type = "hidden" name = "idBeasiswa" value= {{$beasiswa->id_beasiswa}}>
	<input type = "hidden" name = "userid" value= {{$pengguna->id_user}}>

  	<input type = "hidden" name = "idMahasiswa" value={{$pengguna->id_user}} >
  	<input type = "hidden" name = "idPenyeleksi" value= {{$bepe->id_penyeleksi}}>
  	<input type = "hidden" name = "idTahapan" value={{$bepe->id_tahapan}} >


	<h6 style="font-weight:bold"><font color="grey"> Semua data di bawah diambil dari profil. Jika ingin mengganti silahkan rubah dari profil</font></h6>

	<div class="form-group">
		<label for="namaMahasiswa">Nama Mahasiswa</label>

		<input type="text" placeholder="Nama Mahasiswa" class="form-control" name="namaMahasiswa" value="{{$pengguna->nama}}" readonly>
	</div>
	<div class = "row">

		<div class="form-group col-sm-3">
			<label for="NPM">NPM</label>
			<input type="text" placeholder="NPM" class="form-control" name="npm" value="{{$mahasiswa->npm}}" readonly>
		</div>
		<div class="form-group col-sm-4">
			<label for="Email">Email</label>
			<input type="email" placeholder="Email" class="form-control" name="email" value="{{$mahasiswa->email}}" readonly>
		</div>
		<div class="form-group col-sm-2">
			<label for="IPK">IPK</label>
			<input type="number" placeholder="IPK" class="form-control" name="ipk" value="{{$mahasiswa->IPK}}" readonly>
		</div>
	</div>

	<div class = "row">
		<div class="form-group col-sm-4">
			<label for="jenisidentitas">Jenis Identitas</label>
			<input type="text" placeholder="Jenis. Identitas" class="form-control" name="jenisidentitas" value="{{$mahasiswa->jenis_identitas}}" readonly>
		</div>

		<div class="form-group col-sm-5">
			<label for="NoIdentitas">No. Identitas</label>
			<input type="text" placeholder="No. Identitas" class="form-control" name="noidentitas" value="{{$mahasiswa->nomor_identitas}}" readonly>
		</div>
	</div>


	<div class = "row">
		<div class="form-group col-sm-4">
			<label for="namaBank">Nama Bank</label>
			<input type="text" placeholder="No. Identitas" class="form-control" name="namaBank" value="{{$mahasiswa->nama_bank}}" readonly>
		</div>

		<div class="form-group col-sm-5">
			<label for="norek">No. Rekening</label>
			<input type="text" placeholder="No. Rekening" class="form-control" name="norek" value="{{$mahasiswa->nomor_rekening}}" readonly>
		</div>
	</div>

		<div class="form-group">
			<label for="namapemilik">Nama Pemilik Rekening</label>
			<input type="text" placeholder="Nama Pemilik Rekening" class="form-control" name="namapemilik" required="" value="{{$mahasiswa->nama_pemilik_rekening}}" readonly>
		</div>

		<div class="form-group">
			<label for="alamat">Alamat</label>
			<input type="text" placeholder="Alamat" class="form-control" name="alamat" value="{{$mahasiswa->alamat}}" readonly>
		</div>

	<div class = "row">
		<div class="form-group col-sm-4">
			<label for="telp">No. Telpon</label>
			<input type="text" placeholder="No. Telpon" class="form-control" name="telp" value="{{$mahasiswa->nomor_telepon}}" readonly>
		</div>

		<div class="form-group col-sm-5">
			<label for="nohp">No. HP</label>
			<input type="text" placeholder="No. HP" class="form-control" name="nohp" value="{{$mahasiswa->nomor_hp}}" readonly>
		</div>

	</div>

	<div class="row">
		<div class="form-group col-sm-4">
				<label for="penghasilan">Penghasilan Orang Tua (Rp.)</label>
				<input type="text" placeholder="1.000.000" class="form-control" name="penghasilan" value={{$mahasiswa->penghasilan_orang_tua}} readonly>
		</div>
	</div>

	<div>
		@if (count($berkasumum) > 0)
		<h5>Berkas Umum:</h5>
		<div class="row">
			@foreach ($berkasumum as $index => $tmp)
			<div class="col-sm-8">
				<label>{{$index+1}}. {{$tmp->nama_berkas}} - link lihatt</label>
			</div>
			@endforeach
			<div class="col-sm-8">
				link ke profil buat update
			</div>
		</div>
		@endif
	</div>

	<div>
		@if (count($berkas) > 0)
		<h5>Berkas:</h5>
		<div class="row">
			@foreach ($berkas as $index => $tmp)
			<div class="form-group col-sm-8">
				<input name = "nama[{{$index}}]" value="{{$tmp->nama_berkas}}" hidden>
				<input name = "idBerkas[{{$index}}]" value="{{$tmp->id_berkas}}" hidden>
				<label for="berkases[{{$index}}]">{{$index+1}}. {{$tmp->nama_berkas}}</label>
				<input type="file" class="form-control" name="berkases[{{$index}}]" required>
			</div>
			@endforeach
		</div>
		@endif
	</div>

	<div>
		<button type="submit" id="submit-form" class="btn btn-success"> Submit </button>
		<button style ="text-decoration: none"id="cancel" class="btn btn-danger" formnovalidate><a href="{{ url('list-beasiswa	') }}" >Cancel </a></button>
	</div>
</form>


@endsection

@section('script')
<!-- script references -->
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/multiple-select.js') }}"></script>

@endsection
