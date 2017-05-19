@extends('master')

@section('title', 'Edit Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<form id='editScholarshipForm' action = "{{ url('update-beasiswa') }}" onsubmit="return validateForm()" method = "post" data-parsley-validate="">
	<div>
		<h3> Edit Informasi Beasiswa </h3>
		<p style="font-weight:bold"> Semua Kolom Harus Diisi </p>
	</div>

	<input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
	<input type = "hidden" name = "counter" value="1">
	<input type = "hidden" name = "idBeasiswa" value= {{$beasiswa->id_beasiswa}}>

	<div class="form-group">
		<label for="namaBeasiswa">Nama Beasiswa</label><br>
		<input type="text" placeholder="Nama Beasiswa" class="form-control" name="namaBeasiswa" required value= "{{ $beasiswa->nama_beasiswa }}">
	</div>

	<div class="form-group">
		<label for="deskripsiBeasiswa">Deskripsi Beasiswa</label><br>
		<textarea id="message" placeholder="Deskripsi Beasiswa" class="form-control" name="deskripsiBeasiswa" data-parsley-trigger="keyup" data-parsley-minlength="80"
		data-parsley-maxlength="500" data-parsley-minlength-message="Minimal 80 karakter"
		data-parsley-validation-threshold="10" required>{{$beasiswa->deskripsi_beasiswa}}</textarea>
	</div>

		<div class="form-group">
			<div class="input-group col-sm-4">
			<label for="pendonor">Pendonor</label><br>
				<select class="form-control" id = "pendonor" name="pendonor" required>
					<option selected disabled> --Pilih Pendonor-- </option>
					@foreach ($pendonor as $pendonor)
						@if ($pendonor->id_user == $beasiswa->id_pendonor)
						<option selected value= {{ $pendonor->id_user}}> {{$pendonor->nama_instansi}} </option>
						@else
						<option value= {{ $pendonor->id_user}}> {{$pendonor->nama_instansi}} </option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="input-group col-sm-4">
				<label for="kategoriBeasiswa">Kategori Beasiswa</label><br>
				<select class="form-control" name="kategoriBeasiswa" required>
					@foreach ($kategoribeasiswa as $category)
						@if ($category->id_kategori == $beasiswa->id_kategori)
						<option selected value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
						@else
						<option value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="input-group col-sm-4">
				<label for="jenjangBeasiswa">Untuk Jenjang</label><br>
				<select class="form-control" id="jenjang" name="jenjangBeasiswa" required>
					<option selected disabled> --Pilih Jenjang-- </option>
					@foreach ($jenjang as $jenjangbeasiswa)
						@if ($jenjangbeasiswa->id_jenjang == $beasiswa->id_jenjang)
						<option selected value= {{$jenjangbeasiswa->id_jenjang}}> {{$jenjangbeasiswa->nama_jenjang}} </option>
						@else
						<option value= {{$jenjangbeasiswa->id_jenjang}}> {{$jenjangbeasiswa->nama_jenjang}} </option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<div class="input-group col-sm-9">
				<label for="fakultasBeasiswa">Program Studi</label><br>
				<select id="fakultasBeasiswa" name="fakultasBeasiswa" data-toggle="dropdown" required>
						{{$dummy = ''}}
						@foreach($daftarprodi as $key => $prodi)
						@if ($key == 0)
							<optgroup label="{{$prodi->nama_fakultas}}">
							{{$dummy = $prodi->nama_fakultas }}
						@elseif($prodi->nama_fakultas != $dummy)
							</optgroup>
							<optgroup label="{{$prodi->nama_fakultas}}">
							{{$dummy = $prodi->nama_fakultas }}
						@endif
								@foreach($prodidipilih as $sp)
										@if ($sp->id_prodi == $prodi->id_prodi)
											<option selected="selected" value="{{$prodi->id_prodi}}"> {{$prodi->nama_prodi}} </option>
											@break
										@else
											<option value="{{$prodi->id_prodi}}"> {{$prodi->nama_prodi}} </option>
											@break
										@endif
								@endforeach
						@endforeach
				</select>
				<input type="hidden" name="listProdi">
			</div>
		</div>

		<span id="ahoy" style="display:none"></span>

		<div class="form-group">
			<div class="input-group col-sm-4">
				<label for="kuota">Kuota (Mahasiswa)</label><br>
				<input type="number" value ="{{$beasiswa->kuota}}" placeholder="Kuota" class="form-control" name="kuota" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
			</div>
		</div>

		<div class="form-group">
			<label for="mataUang">Mata Uang</label>
			<p> Mata Uang Yang Digunakan </p>
			<div class="input-group col-sm-4">
				<select class="form-control" name="mataUang" id="mataUang" required>
					@foreach ($matauang as $mu)
						@if ($beasiswa->currency == $mu->id_mata_uang)
							<option selected value= {{ $mu->nama_mata_uang}}> {{$mu->nama_mata_uang}} </option>
						@else
							<option value= {{ $mu->nama_mata_uang}}> {{$mu->nama_mata_uang}} </option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

	<div class="form-group">
		<label for="totalDanaPendidikan">Dana Pendidikan</label>
		<p> Besaran dana pendidikan yang akan diberikan secara total. <br>Dana ini akan dipergunakan untuk membantu membayar uang kuliah (BOP) </p>
		<div class="input-group col-sm-4">
			<input  value= "{{$beasiswa->dana_pendidikan}}" class="form-control" name="danaPendidikan" data-parsley-trigger="keyup"  data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang" name="addon-mataUang"></span>
		</div>
	</div>

	<div class="form-group">
		<label for="totalDanaHidup">Dana Biaya Hidup</label>
		<p> Besaran dana biaya hidup yang akan diberikan secara total. <br>Contoh biaya hidup ini seperti biaya makan, transportasi, dan tempat tinggal. </p>
		<div class="input-group col-sm-4">
			<input value= "{{$beasiswa->dana_hidup}}" class="form-control" name="danaHidup" data-parsley-trigger="keyup"  data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang3" name="addon-mataUang"></span>
		</div>
	</div>


	<div class="form-group">
		<label for="nominal">Nominal Biaya Pendidikan</label>
		<p> Dana yang akan diberikan per mahasiswa </p>
		<div class="input-group col-sm-4">
			<input value= "{{$beasiswa->nominal_pendidikan}}" class="form-control" name="nominalPendidikan" data-parsley-trigger="keyup" data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang2" name="addon-mataUang2"></span>
		</div>
	</div>

	<div class="form-group">
		<label for="nominal">Nominal Biaya Hidup</label>
		<p> Dana yang akan diberikan per mahasiswa </p>
		<div class="input-group col-sm-4">
			<input value= "{{$beasiswa->nominal_hidup}}" class="form-control" name="nominalHidup" data-parsley-trigger="keyup" data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang2" name="addon-mataUang3"></span>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="periode">Periode</label>
			<p> Periode beasiswa diberikan setiap..</p>
			<select class="form-control" name="periode" id="periode" required>
				@foreach ($periode as $periode)
					@if ($beasiswa->currency == $mu->id_mata_uang)
						<option selected value= {{ $periode->nama_periode}}> {{ $periode->nama_periode}} </option>
					@else
						<option value= {{ $periode->nama_periode}}> {{ $periode->nama_periode}} </option>
					@endif
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="jangka">Jangka</label>
		<p>Berapa periode beasiswa akan diberikan?</p>
		<div class="input-group col-sm-4">
			<input value= "{{$beasiswa->jangka}}" type="number" placeholder="4" class="form-control" name="jangka" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
			<span class="input-group-addon" id="addon-jangka" name="addon-jangka"></span>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="tanggalBuka">Tanggal Buka</label><br>
			<input value= "{{$beasiswa->tanggal_buka}}" type="date" class="form-control" name="tanggalBuka" data-date-format="YYYY/MM/DD" required>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="tanggalTutup">Tanggal Tutup</label><br>
			<input value= "{{$beasiswa->tanggal_tutup}}" type="date" class="form-control" name="tanggalTutup" data-date-format="YYYY/MM/DD" required>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="waktuTagih">Waktu Tagih</label><br>
			<p>Masukkan waktu kapan akan dilakukannya penagihan kepada pendonor</p>
			<input value= "{{$beasiswa->waktu_tagih}}" type="date" class="form-control" name="waktuTagih" data-date-format="YYYY/MM/DD" required>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-9">
			<label for="syarat">Syarat &nbsp;</label>
			<input type="hidden" id="arraySyarat" name="arraySyarat">
			<button type="button" class="btn btn-default" id="buttonTambahSyarat" onclick="insertRow()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
			<div class="form-group" name="syarat">
				<div class="input-group col-sm-12">
					<!-- invalidate? -->
					@foreach ($syarat as $key => $s)
	 					<br><input value= "{{ $s->syarat}}" type = "text" class="form-control col-sm-9" name="syarat{{++$key}}" required><br><br>
	 				@endforeach
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-9">
			<label for="berkasPersyaratan">Berkas Persyaratan Pendaftaran</label><br>
			<select id="berkas" multiple="multiple" data-toggle="dropdown" name="berkas" required>
				@foreach ($berkas as $b)
					@foreach ($beasiswaberkas as $bb)
							@if ($bb->id_berkas == $b->id_berkas)
								<?php $set = 1; ?>
								@break
							@else
								<?php $set = 0; ?>
								@endif
					@endforeach
						@if ($set == 1)
						<option selected="selected" value= {{ $b->id_berkas}}> {{$b->nama_berkas}} </option>
						@else
						<option value= {{ $b->id_berkas}}> {{$b->nama_berkas}} </option>
						@endif

				@endforeach
			</select>
			<input type="hidden" name="listBerkas">
		</div>
	</div>

	<div>
		<button type="submit" id="submit-form" class="btn"> Submit </button>
		<button style ="text-decoration: none"id="cancel" class="btn btn-danger" formnovalidate><a href="{{ url('list-beasiswa') }}" >Cancel </a></button>
	</div>
</form>

<div name= "alertDanaModal" class="alert alert-danger alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Jumlah dana biaya hidup ditambah denga  biaya pendidikan harus sama dengan jumlah kuota x (nominal biaya pendidikan + nominal biaya hidup) x jangka</strong>
</div>

<div name= "alertDateModal" class="alert alert-danger alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Tanggal Tutup Harus Lebih Besar Dari Tanggal Buka</strong>
</div>
@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/multiple-select.js') }}"></script>
<script>

  $('#berkas').multipleSelect({
		placeholder: "Pilih berkas",
		width: "100%"
	});

	function cekProdi(z, idFakultas){
		//console.log("length nya: " +z);
		if(z==1){
			var p = document.getElementsByClassName("pegawaifakultas");
			var i;
			for (i = 0; i < p.length; i++) {
			    p[i].style.display = "block";
			}
		}else {
			var p = document.getElementsByClassName("pegawaifakultas");
			var i;
			for (i = 0; i < p.length; i++) {
			    p[i].style.display = "none";
			}
		}
	}

	$('#editScholarshipForm').parsley({
	successClass: 'has-success',
	errorClass: 'has-error',
	classHandler: function(el) {
		return el.$element.closest(".form-group");
	},
	errorsContainer: function(el) {
    return el.$element.closest('.form-group');
	},
	errorsWrapper: '<span class="help-block"></span>',
	errorTemplate: "<span></span>"
	});


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
		elem.innerHTML = '<div class="input-group col-sm-12"><input type = "text" class="form-control col-sm-9" name="syarat'+counter+'" required><span class="input-group-btn"><button class="btn btn-danger" onclick="removeSyarat('+counter+')"> x </button></span><br>';
		x.appendChild(elem);
	}
	function removeSyarat(i){
	//	counter-=1;
		var j;
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
		var danaHidup = document.getElementsByName('danaHidup')[0].value;
		var danaPendidikan = document.getElementsByName('danaPendidikan')[0].value;
		danaHidup = danaHidup.replace (/,/g, "");
		danaPendidikan = danaPendidikan.replace (/,/g, "");
		var kuota = document.getElementsByName('kuota')[0].value;
		var nominalP = document.getElementsByName('nominalPendidikan')[0].value;
		var nominalH = document.getElementsByName('nominalHidup')[0].value;
		nominalP = nominalP.replace (/,/g, "");
		nominalH = nominalH.replace (/,/g, "");
		danaHidup = parseInt(danaHidup);
		danaPendidikan = parseInt(danaPendidikan);
		nominalP = parseInt(nominalP);
		nominalH = parseInt(nominalH);
		document.getElementsByName('danaHidup')[0].value = danaHidup;
		document.getElementsByName('danaPendidikan')[0].value = danaPendidikan;
		document.getElementsByName('nominalPendidikan')[0].value = nominalP;
		document.getElementsByName('nominalHidup')[0].value = nominalH;


		var jangka = document.getElementsByName('jangka')[0].value;
		var jumlahDana = kuota*(nominalP+nominalH)*jangka;
		var tanggalBuka = new Date(document.getElementsByName('tanggalBuka')[0].value);
		var tanggalTutup = new Date(document.getElementsByName('tanggalTutup')[0].value);
		var now = new Date();

		document.getElementsByName('arraySyarat')[0].value = idSyarat;

		var x = $('#fakultasBeasiswa').multipleSelect('getSelects');
		console.log(x);
		document.getElementsByName('listProdi')[0].value = x;

		var q = $('#berkas').multipleSelect('getSelects');
		document.getElementsByName('listBerkas')[0].value = q;

		if (!(tanggalBuka.getTime() < tanggalTutup.getTime()) )
		{
			$("[name='alertDateModal']").show();
			return false;
		}
		else if(!(tanggalTutup.getTime() > now.getTime())){
			$("[name='alertDateModal2']").show();
			return false;
		}
		else if (tanggalBuka.getTime() < tanggalTutup.getTime() && (danaHidup+danaPendidikan) == kuota*(nominalP+nominalH)*jangka)
		{
			return true;
		}
		else if((danaHidup+danaPendidikan) != jumlahDana){
			$("[name='alertDanaModal']").show();
			return false;
		}
		else{
			$("[name='alertDateModal']").show();
			return false;
		}

	}
	$(function () {
		$('#editScholarshipForm').parsley().on('field:validated', function() {
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
			$("#fakultasBeasiswa").change(function(){
				var x = $('#fakultasBeasiswa').multipleSelect('getSelects');

				document.getElementById("ahoy").innerHTML = x;
				var idFakultas = document.getElementById("ahoy").innerHTML;
				//console.log(idFakultas);
				var z = document.getElementById("ahoy").innerHTML.length;
				cekProdi(z,idFakultas);
			});

		$("#mataUang").change(function(){
			var mataUang = $("#mataUang").val();

			document.getElementById("addon-mataUang").innerHTML = mataUang;
			document.getElementById("addon-mataUang2").innerHTML = mataUang;
			document.getElementById("addon-mataUang3").innerHTML = mataUang;
		});

		$("#periode").change(function(){
			var periode = $("#periode").val();

			document.getElementById("addon-jangka").innerHTML = periode;
		});

		//#ALVINSPRINT2
		$("#pendonor").change(function(){
			var idPendonor = $("#pendonor").val();
			var pendonor = $("#pendonor").find('option:selected').text()
			$(".pendonorOpt").val(idPendonor);
			$(".pendonorOpt").html(pendonor);
			$(".pendonorOpt").removeAttr("disabled");
			$(".pendonorOpt").removeAttr("style");
		});

		$("#jenjang").change(function(){
			var jenjang = $("#jenjang").val();
			console.log(jenjang);
			if (jenjang == {{$beasiswa->id_jenjang}})
			{
				reloadProdi();
			}
			else{
			fillProdi(jenjang);}
		});

		$("[name='danaHidup']").change(function(){
			var danaHidup = $("[name='danaHidup']").val();

			addComas("danaHidup",danaHidup);
		});

		$("[name='danaPendidikan']").change(function(){
			var danaPendidikan = $("[name='danaPendidikan']").val();

			addComas("danaPendidikan",danaPendidikan);
		});

		$("[name='nominalPendidikan']").change(function(){
			var nominal = $("[name='nominalPendidikan']").val();

			addComas("nominalPendidikan",nominalPendidikan);
		});

		$("[name='nominalHidup']").change(function(){
			var nominal = $("[name='nominalHidup']").val();

			addComas("nominalHidup",nominalHidup);
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
			url:'{{ url('/retrieve-prodi') }}',
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
		function reloadProdi(jenjang)
		{
			$('#fakultasBeasiswa').empty();
			var html = [];

			@foreach($daftarprodi as $key => $prodi)
			@if ($key == 0)
				 html.push('<optgroup label="{{$prodi->nama_fakultas}}">');
			@elseif($prodi->nama_fakultas != $daftarprodi[$key-1])
				html.push('</optgroup>');
				html.push('<optgroup label="{{$prodi->nama_fakultas}}">');

			 @endif
			@foreach($prodidipilih as $sp)
							@if ($sp->id_prodi == $prodi->id_prodi)
								html.push('<option selected="selected" value="{{$prodi->id_prodi}}"> {{$prodi->nama_prodi}} </option>');
								@break
							@else
								html.push('<option value="{{$prodi->id_prodi}}"> {{$prodi->nama_prodi}} </option>');
								@break
							@endif
					@endforeach
			@endforeach
			$('#fakultasBeasiswa').html(html.join('')).multipleSelect();
	}


</script>
@endsection
