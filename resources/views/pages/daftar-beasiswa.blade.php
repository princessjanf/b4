@extends('master')

@section('title', 'Daftar Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<form id='daftarScholarshipForm' action = "{{ url('register-beasiswa') }}" onsubmit="return validateForm()" method = "post" data-parsley-validate="" enctype="multipart/form-data">
	<div>
		<h3> Daftar Beasiswa </h3>
		<p style="font-weight:bold"> Semua Kolom Harus Diisi </p>
	</div>

	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
	<input type = "hidden" name = "idBeasiswa" value= {{$beasiswa->id_beasiswa}}>
	<input type = "hidden" name = "userid" value= {{$pengguna->id_user}}>
  <input type = "hidden" name = "idMahasiswa" value={{$pengguna->id_user}} >


	<div class="form-group">
		<label for="namaMahasiswa">Nama Mahasiswa</label>

		<input type="text" placeholder="Nama Mahasiswa" class="form-control" name="namaMahasiswa" required="">
	</div>

	<div class = "row">
		<div class="form-group col-sm-3">
			<label for="NPM">NPM</label>
			<input type="text" placeholder="NPM" class="form-control" name="npm" required="">
		</div>
		<div class="form-group col-sm-3">
			<label for="Email">Email</label>
			<input type="email" placeholder="Email" class="form-control" name="email" required="">
		</div>
		<div class="form-group col-sm-3">
			<label for="IPK">IPK</label>
			<input type="number" placeholder="IPK" class="form-control" name="ipk" required="" step="0.01">
		</div>
	</div>

	<div class = "row">
		<div class="form-group col-sm-4">
			<label for="jenisidentitas">Jenis Identitas</label>
			<select class="form-control" id="identitas" name="jenisidentitas">
				<option selected disabled> --Pilih Identitas-- </option>
				<option value= "KTP"> KTP </option>
				<option value= "SIM"> SIM </option>
				<option value= "KTM"> KTM </option>
				<option value= "Paspor"> Paspor </option>
			</select>
		</div>
		<div class="form-group col-sm-5">
			<label for="NoIdentitas">No. Identitas</label>
			<input type="text" placeholder="No. Identitas" class="form-control" name="noidentitas" required="">
		</div>
	</div>


	<div class = "row">
		<div class="form-group col-sm-4">
			<label for="jenisrek">Nama Bank</label>
			<select class="form-control" id="jenisrek" name="jenisrek">
				<option selected disabled> --Pilih Bank-- </option>
				<option value= "BNI"> BNI </option>
				<option value= "BRI"> BRI </option>
				<option value= "Mandiri"> Mandiri </option>
				<option value= "BCA"> BCA </option>
				<option value= "CIMB Niaga"> CIMB Niaga </option>
				<option value= "DKI"> DKI </option>
				<option value= "Danamon"> Danamon </option>
				<option value= "OCBC NISP"> OCBC NISP </option>
				<option value= "Bukopin"> Bukopin </option>
			</select>
		</div>

		<div class="form-group col-sm-5">
			<label for="norek">No. Rekening</label>
			<input type="text" placeholder="No. Rekening" class="form-control" name="norek" required="">
		</div>
	</div>

		<div class="form-group">
			<label for="namapemilik">Nama Pemilik Rekening</label>
			<input type="text" placeholder="Nama Pemilik Rekening" class="form-control" name="namapemilik" required="" maxlength="20">
		</div>

		<div class="form-group">
			<label for="alamat">Alamat</label>
			<input type="text" placeholder="Alamat" class="form-control" name="alamat" required="">
		</div>

	<div class = "row">
		<div class="form-group col-sm-4">
			<label for="telp">No. Telpon</label>
			<input type="text" placeholder="No. Telpon" class="form-control" name="telp" required="">
		</div>

		<div class="form-group col-sm-5">
			<label for="nohp">No. HP</label>
			<input type="text" placeholder="No. HP" class="form-control" name="nohp" required="">
		</div>

	</div>

	<div class="row">
		<div class="form-group col-sm-4">
				<label for="penghasilan">Penghasilan Orang Tua (Rp.)</label>
				<input type="text" placeholder="1.000.000" class="form-control" name="penghasilan" required="">
		</div>
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
