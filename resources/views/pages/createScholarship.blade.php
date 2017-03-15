@extends('main')

@section('title', '| Create Scholarship')

@section('nav.home')
class="active"
@endsection

@section('body')
<div class="container">
	<form id='createScholarshipForm' action = "/insertScholarship" method = "post" data-parsley-validate="">
		<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
		<div class="form-group">
			<label for="namaBeasiswa">Nama Beasiswa</label>
			<input type="text" class="form-control" name="namaBeasiswa" required="">
		</div>
		<div class="form-group">
			<label for="deskripsiBeasiswa">Deskripsi Beasiswa</label>
			<textarea id="message" class="form-control" name="deskripsiBeasiswa" data-parsley-trigger="keyup" data-parsley-minlength="20"
			data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."
			data-parsley-validation-threshold="10"></textarea>
		</div>
		<div class="form-group">
			<label for="nominal">Nominal</label>
			<input type="number" class="form-control" name="nominal" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="8" required>
		</div>
		<div class="form-group">
			<label for="totalDana">Total Dana</label>
			<input type="number" class="form-control" name="totalDana" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="20" required>
		</div>
		<div class="form-group">
			<label for="kategoriBeasiswa">Kategori Beasiswa</label>
			<select class="form-control" name="kategoriBeasiswa">
				@foreach ($categories as $category)
				<option value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
				@endforeach
			</select>
		</div>

		<div class="form-group">
			<label for="tanggalBuka">Tanggal Buka</label>
			{!!Form::date('tanggalBuka', \Carbon\Carbon::now())!!}
		</div>
		<div class="form-group">
			<label for="tanggalTutup">Tanggal Tutup</label>
			{!!Form::date('tanggalTutup', \Carbon\Carbon::now())!!}
		</div>
		<div class="form-group">
			<label for="syaratBeasiswa">Syarat Beasiswa</label>
			<input type="text" class="form-control" name="syaratBeasiswa">
		</div>

		<label for="pendonor">Pendonor</label>
		<select class="form-control" name="pendonor">
			@foreach ($pendonor as $pendonor)
			<option value= {{ $pendonor->id_pendonor}}> {{$pendonor->nama_instansi}} </option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<label for="kuota">Kuota</label>
		<input type="number" class="form-control" name="kuota" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
	</div>
	<button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
@endsection
