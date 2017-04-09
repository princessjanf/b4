@extends('master')

@section('title', 'Buat Entri Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<form id='createScholarshipForm' action = "{{ url('insert-beasiswa') }}" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
	<div>
		<h3> Informasi Beasiswa </h3>
		<p style="font-weight:bold"> Semua Kolom Harus Diisi </p>
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
		data-parsley-maxlength="500" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."s
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
		<div class="form-group col-sm-3">
			<label for="kategoriBeasiswa">Kategori Beasiswa</label>
			<select class="form-control" name="kategoriBeasiswa">
				@foreach ($kategoribeasiswa as $category)
				<option value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label for="jenjangBeasiswa">Untuk Jenjang</label>
			<select class="form-control" id="jenjang" name="jenjangBeasiswa">
				<option selected disabled> --Pilih Jenjang-- </option>
				@foreach ($jenjang as $jenjangbeasiswa)
				<option value= {{ $jenjangbeasiswa->id_jenjang}}> {{$jenjangbeasiswa->nama_jenjang}} </option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-3">
			<label for="fakultasBeasiswa">Fakultas Beasiswa</label>
			<select id="fakultasBeasiswa" name="fakultasBeasiswa" data-toggle='dropdown'>
			</select>
			<input type="hidden" name="listProdi">
		</div>
	</div>

	<div class = "row">
		<div class="form-group col-sm-3">
			<label for="totalDana">Mata Uang</label>
			<p> Mata Uang Yang Digunakan </p>
			<select class="form-control" name="mataUang">
				<option selected disabled> --Pilih-- </option>
				<option value= "IDR"> IDR </option>
				<option value= "USD"> USD </option>
				<option value= "EUR"> EUR </option>
				<option value= "CAD"> CAD </option>
				<option value= "GBP"> GBP </option>
				<option value= "CHF"> CHF </option>
				<option value= "NZD"> NZD </option>
				<option value= "AUD"> AUD </option>
				<option value= "JPY"> JPY </option>
			</select>
		</div>
		<div class="form-group col-sm-5">
			<label for="totalDana">Total Dana</label>
			<p> Total dana yang akan diberikan ke universitas </p>
			<input class="form-control" name="totalDana"  data-parsley-trigger="keyup" data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
		</div>
		<div class="form-group col-sm-4">
			<label for="periode">Periode</label>
			<p> Periode beasiswa diberikan </p>
			<select class="form-control" name="periode">
				<option selected disabled> --Pilih Periode-- </option>
				<option value= "bulan"> Bulan </option>
				<option value= "semester"> Semester </option>
				<option value= "tahun"> Tahun </option>
			</select>
		</div>
	</div>

	<div class = "row">
		<div class="form-group col-sm-5">
			<label for="nominal">Nominal</label>
			<p> Dana yang akan diberikan kepada  mahasiswa </p>
			<input class="form-control" name="nominal"  data-parsley-trigger="keyup" data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
		</div>

		<div class="form-group col-sm-4">
			<label for="jangka">Jangka (Per Periode) </label>
			<p> Jangka waktu pemberian beasiswa </p>
			<input type="number" placeholder="4" class="form-control" name="jangka" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
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

	<label for="syarat">Syarat &nbsp;</label>
	<input type="hidden" id="arraySyarat" name="arraySyarat">
	<button type="button" class="btn btn-default" id="buttonTambahSyarat" onclick="insertRow()">+</button>
	<div class="form-group" name="syarat">
		<br><input type = "text" class="form-control" name="syarat1" required>
	</div>

	<div>
		<button type="submit" id="submit-form" class="btn btn-success"> Submit </button>
		<button style ="text-decoration: none"id="cancel" class="btn btn-danger" formnovalidate><a href="{{ url('list-beasiswa') }}" >Cancel </a></button>
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

<div name= "alertDateModal2" class="alert alert-danger alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Tanggal Tutup Harus Lebih Besar Dari Tanggal Hari Ini</strong>
</div>
@endsection

@section('script')
<!-- script references -->
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/multiple-select.js') }}"></script>
<script>
	$("[name='alertDateModal']").hide();
	$("[name='alertDateModal2']").hide();
	$("[name='alertDanaModal']").hide();
	counter=1;
	var idSyarat = [];
	idSyarat.push(1);
	function insertRow(){
		counter+=1;
		idSyarat.push(counter);
		console.log(idSyarat);
		document.getElementsByName("counter")[0].value = counter;
		var theForm = document.getElementById('createScholarshipForm');
		var x = document.getElementsByName('syarat')[0];
		var elem = document.createElement('div');
		elem.setAttribute("id","syarat"+counter);
		elem.innerHTML = '</br><input type = "text" class="form-control col-sm-11" required name="syarat'+counter+'"><button lass="col-sm-1" onclick="removeSyarat('+counter+')"> - </button>	';
		x.appendChild(elem);

	}
	function removeSyarat(i){
	//	counter-=1;
		var j;
		var l;
		$("#syarat"+i).remove();
		for (j = 0; j < idSyarat.length; j++) {

			console.log(idSyarat[j] + " " + i);
			if (idSyarat[j] == i)
			{
				 if (j == idSyarat.length)
				 {
					 idSyarat.pop();
				 }
				 else{
					 idSyarat.splice(j, 1);
				 }
				 break;
			}
		}
		console.log(idSyarat);

	}
	function validateForm(){
		var totalDana = document.getElementsByName('totalDana')[0].value;
		var kuota = document.getElementsByName('kuota')[0].value;
		var nominal = document.getElementsByName('nominal')[0].value;
		var jangka = document.getElementsByName('jangka')[0].value;
		var jumlahDana = kuota*nominal*jangka;
		var tanggalBuka = new Date(document.getElementsByName('tanggalBuka')[0].value);
		var tanggalTutup = new Date(document.getElementsByName('tanggalTutup')[0].value);
		var now = new Date();


		document.getElementsByName('arraySyarat')[0].value = idSyarat;
		var x = $('#fakultasBeasiswa').multipleSelect('getSelects');
		document.getElementsByName('listProdi')[0].value = x;
		if (!(tanggalBuka.getTime() < tanggalTutup.getTime()) )
		{
			$("[name='alertDateModal']").show();
			return false;
		}
		else if(!(tanggalTutup.getTime() > now.getTime())){
			$("[name='alertDateModal2']").show();
			return false;
		}
		else if (tanggalBuka.getTime() < tanggalTutup.getTime() && totalDana == kuota*nominal*jangka)
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

	$(function() {
		$('#fakultasBeasiswa').change(function() {}).multipleSelect({
			width: '100%'
		});
	});

	$(document).ready(function(){

		$("#jenjang").change(function(){
			var jenjang = $("#jenjang").val();

			fillProdi(jenjang);
		});

		$("[name='totalDana']").change(function(){
			var totalDana = $("[name='totalDana']").val();

			addComas("totalDana",totalDana);
		});
		$("[name='nominal']").change(function(){
			var nominal = $("[name='nominal']").val();

			addComas("nominal",nominal);
		});
	});

	function addComas(place, nStr)
	{

		nStr = nStr.toString();
		var x1 = nStr.replace (/,/g, "");

		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}

		document.getElementsByName(place)[0].value = x1;
	}
	function fillProdi(jenjang)
	{
		$.ajax({
			type:'POST',
			url:'retrieve-prodi',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
			'jenjang': jenjang},
			success:function(data){
				var idFakultas = 0;
				$('#fakultasBeasiswa').empty();
				if (data[0] == null) {
					$('#fakultasBeasiswa').multipleSelect("refresh");
				}
				else{
					var html = [];
					$.each(data, function(i,item){
						if (idFakultas == 0)
						{
							idFakultas =  data[i].id_fakultas;
							html.push('<optgroup label = "' + data[i].nama_fakultas +'">');
						}
						else if (idFakultas != data[i].id_fakultas){
							idFakultas =  data[i].id_fakultas;
							html.push('</optgroup>');
							html.push('<optgroup label = "' + data[i].nama_fakultas +'">');
							//$('#fakultasBeasiswa').append('<optgroup label = "' + data[i].nama_fakultas +'">').multipleSelect("refresh");
						}
						html.push('<option value="' + data[i].id_prodi + '">' + data[i].nama_prodi + '</option>');
					});
					$('#fakultasBeasiswa').html(html.join('')).multipleSelect(); // add options to select

				}
			}
		});
	}
</script>
@endsection
