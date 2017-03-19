@extends('master')

@section('title', 'Edit Beasiswa')

@section('content')
<form id='createScholarshipForm' action = "./insert-beasiswa" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
	<div>
		<h3> Informasi Beasiswa </h3>
	</div>
	<div>
		<button type="submit" id="submit-form"> Submit </button>
	</div>
	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
	<input type = "hidden" name = "counter" value="1">

	<div class="form-group">
		<label for="namaBeasiswa">Nama Beasiswa</label>
		<input type="text" placeholder="Nama Beasiswa" class="form-control" name="namaBeasiswa" required="">
	</div>

	<div class="form-group">
		<label for="deskripsiBeasiswa">Deskripsi Beasiswa</label>
		<textarea id="message" placeholder="Deskripsi Beasiswa" class="form-control" name="deskripsiBeasiswa" data-parsley-trigger="keyup" data-parsley-minlength="20"
		data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."s
		data-parsley-validation-threshold="10"></textarea>
	</div>
	<div class = "row">
		<div class="form-group col-sm-6">
			<label for="pendonor">Pendonor</label>
			<select class="form-control" name="pendonor">
				@foreach ($pendonor as $pendonor)
				<option value= {{ $pendonor->id_pendonor}}> {{$pendonor->nama_instansi}} </option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-sm-3">
			<label for="kuota">Kuota (Mahasiswa)</label>
			<input type="number" placeholder="125" class="form-control" name="kuota" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
		</div>

	</div>
	<div class = "row">
		<div class="form-group col-sm-2">
			<label for="kategoriBeasiswa">Kategori Beasiswa</label>
			<select class="form-control" name="kategoriBeasiswa">
				@foreach ($kategoribeasiswa as $category)
				<option value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-3">
			<label for="jenjangBeasiswa">Untuk Jenjang</label>
			<select class="form-control" name="jenjangBeasiswa">
				@foreach ($jenjang as $jenjangbeasiswa)
				<option value= {{ $jenjangbeasiswa->id_jenjang}}> {{$jenjangbeasiswa->nama_jenjang}} </option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label for="fakultasBeasiswa">Fakultas Beasiswa</label>
			<select class="form-control" name="fakultasBeasiswa">
				@foreach ($fakultasbeasiswa as $fakultas)
				<option value= {{ $fakultas->id_fakultas}}> {{$fakultas->nama_fakultas}} </option>
				@endforeach
			</select>
		</div>
	</div>
	<div class = "row">
		<div class="form-group col-sm-5">
			<label for="totalDana">Total Dana</label>
			<p> Total dana yang akan diberikan ke universitas </p>
			<input type="number" class="form-control" name="totalDana" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="20" required>
		</div>
		<div class="form-group col-sm-4">
			<label for="periode">Periode</label>
			<p> Periode beasiswa diberikan </p>
			<input type="number" class="form-control" placeholder="2016.1 - 2017.4" name="periode" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="8" required>
		</div>
	</div>
	<div class = "row">
		<div class="form-group col-sm-5">
			<label for="nominal">Nominal</label>
			<p> Dana yang akan diberikan kepada  mahasiswa </p>
			<input type="number" class="form-control" name="nominal" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="8" required>
		</div>

		<div class="form-group col-sm-4">
			<label for="jangka">Jangka (Semester) </label>
			<p> Jangka waktu pemberian beasiswa </p>
			<input type="number" placeholder="4 (4 Semester)" class="form-control" name="jangka" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
		</div>
	</div>
	<div class = "row">

		<div class="form-group col-sm-4">
			<label for="tanggalBuka">Tanggal Buka</label>
			<input type="date" name="tanggalBuka" data-date-format="YYYY/MM/DD" required>
		</div>
		<div class="form-group col-sm-4">
			<label for="tanggalTutup">Tanggal Tutup</label>
			<input type="date" name="tanggalTutup" data-date-format="YYYY/MM/DD" required>
		</div>

	</div>

	<div class="row">
		<label for="syarat">Syarat</label>
		<div class="button">
			<button type="button" class="btn btn-default" id="buttonTambahSyarat" onclick="insertRow()">+</button>
		</div>
		<div class="form-group" name="syarat">
			<input type = "text" class="form-control" name="syarat1" required>
		</div>
	</div>

</form>

<div name= "alertDanaModal" class="alert alert-danger alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Jumlah total dana harus sama dengan jumlah kuota x nominal x jangka</strong>
</div>

<div name= "alertDateModal" class="alert alert-danger alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Tanggal Tutup Harus Lebih Besar Dari Tanggal Buka</strong>
</div>

@endsection

@section('scripts')
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script>
	$("[name='alertDateModal']").hide();
	$("[name='alertDanaModal']").hide();
	counter=1;
	function insertRow(){
		counter+=1;
		document.getElementsByName("counter")[0].value = counter;
		var theForm = document.getElementById('createScholarshipForm');
		/*
		var tmp = document.createElement("input");
		tmp.name = "syarat"+counter;
		tmp.type = "text";
		console.log(tmp.name);
		theForm.appendChild(tmp);
		var r = document.createElement('span');
		theForm.appendChild(r);
		*/
		var x = document.getElementsByName('syarat')[0];
		var elem = document.createElement('div');
		elem.innerHTML = '<input type = "text" class="form-control" name="syarat'+counter+'">';
		x.appendChild(elem);
		theForm.appendChild(x);
	}

	function validateForm(){
		var totalDana = document.getElementsByName('totalDana')[0].value;
		var kuota = document.getElementsByName('kuota')[0].value;
		var nominal = document.getElementsByName('nominal')[0].value;
		var jangka = document.getElementsByName('jangka')[0].value;
		var jumlahDana = kuota*nominal*jangka;
		var tanggalBuka = new Date(document.getElementsByName('tanggalBuka')[0].value);
		var tanggalTutup = new Date(document.getElementsByName('tanggalTutup')[0].value);
		if (tanggalBuka.getTime() < tanggalTutup.getTime() && totalDana == kuota*nominal*jangka)
		{
			return true;
		}
		else if(totalDana != jumlahDana){
			$("[name='alertDanaModal']").show();
			return false;
		}
		else{
			$("[name='alertDateModal']").show();
			return false;
		}

	}
	$(function () {
		$('#createScholarshipForm').parsley().on('field:validated', function() {
			var ok = $('.parsley-error').length === 0;
			$('.bs-callout-info').toggleClass('hidden', !ok);
			$('.bs-callout-warning').toggleClass('hidden', ok);
		})
		.on('form:submit', function() {
			return true;
		});
	});

</script>
@endsection
