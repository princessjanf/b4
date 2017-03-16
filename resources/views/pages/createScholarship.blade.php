@extends('main')

@section('title', '| Create Scholarship')

@section('nav.home')
class="active"
@endsection

@section('body')
<div class="container">
	<form id='createScholarshipForm' action = "/insertScholarship" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
		<div class="form-group">
		<button type="submit" class="btn btn-default">Submit</button>
		</div>
		<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
		<input type = "hidden" name = "counter" value="1">
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
			<input type="date" name="tanggalBuka" data-date-format="YYYY/MM/DD" required>
		</div>
		<div class="form-group">
			<label for="tanggalTutup">Tanggal Tutup</label>
			<input type="date" name="tanggalTutup" data-date-format="YYYY/MM/DD" required>
		</div>
		<div class="form-group">
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
	<div class="form-group" name="syarat">
		<label for="syarat">Syarat</label>
		<input type = "text" class="form-control" name="syarat1" required>
	</div>

</form>
<div>
		<button type="button" class="btn btn-default pull-right" id="buttonTambahSyarat" onclick="insertRow()">+</button>
</div>
</div>
@endsection

<script>
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
			var tanggalBuka = new Date(document.getElementsByName('tanggalBuka')[0].value);
			var tanggalTutup = new Date(document.getElementsByName('tanggalTutup')[0].value);
			if (tanggalBuka.getTime() < tanggalTutup.getTime())
			{
				return true;
			}
			return false;
			//show alert?
	}


</script>
