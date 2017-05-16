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
	<input type = "hidden" name = "counterT" value="1">

	<div class="form-group">
		<label for="namaBeasiswa">Nama Beasiswa</label><br>
		<input type="text" placeholder="Nama Beasiswa" class="form-control" name="namaBeasiswa" required="">
	</div>

	<div class="form-group">
		<label for="deskripsiBeasiswa">Deskripsi Beasiswa</label><br>
		<textarea id="message" placeholder="Deskripsi Beasiswa" class="form-control" name="deskripsiBeasiswa" data-parsley-trigger="keyup" data-parsley-minlength="80"
		data-parsley-maxlength="500" data-parsley-minlength-message="Come on! You need to enter at least a 80 character comment.."s
		data-parsley-validation-threshold="10" required></textarea>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
		<label for="pendonor">Pendonor</label><br>
			<select class="form-control" id = "pendonor" name="pendonor" required>
				<option selected disabled> --Pilih Pendonor-- </option>
				@foreach ($pendonor as $pendonor)
				<option value= {{ $pendonor->id_user}}> {{$pendonor->nama_instansi}} </option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="kategoriBeasiswa">Kategori Beasiswa</label><br>
			<select class="form-control" name="kategoriBeasiswa" required>
				<option selected disabled> --Pilih Kategori Beasiswa-- </option>
				@foreach ($kategoribeasiswa as $category)
				<option value= {{ $category->id_kategori}}> {{$category->nama_kategori}} </option>
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
				<option value= {{ $jenjangbeasiswa->id_jenjang}}> {{$jenjangbeasiswa->nama_jenjang}} </option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-9">
			<label for="fakultasBeasiswa">Program Studi</label><br>
			<select id="fakultasBeasiswa" name="fakultasBeasiswa" data-toggle="dropdown" required>
			</select>
			<input type="hidden" name="listProdi">
		</div>
	</div>

	<span id="ahoy" style="display:none"></span>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="kuota">Kuota (Mahasiswa)</label><br>
			<input type="number" placeholder="Kuota" class="form-control" name="kuota" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
		</div>
	</div>

	<div class="form-group">
		<label for="mataUang">Mata Uang</label>
		<p> Mata Uang Yang Digunakan </p>
		<div class="input-group col-sm-4">
			<select class="form-control" name="mataUang" id="mataUang" required>
				<option selected disabled> --Pilih Mata Uang-- </option>
				@foreach ($matauang as $mu)
				<option value= {{ $mu->nama_mata_uang}}> {{$mu->nama_mata_uang}} </option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="totalDanaPendidikan">Dana Pendidikan</label>
		<p> Besaran dana pendidikan yang akan diberikan secara total. <br>Dana ini akan dipergunakan untuk membantu membayar uang kuliah (BOP) </p>
		<div class="input-group col-sm-4">
			<input class="form-control" name="danaPendidikan" data-parsley-trigger="keyup"  data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang" name="addon-mataUang"></span>
		</div>
	</div>

	<div class="form-group">
		<label for="totalDanaHidup">Dana Biaya Hidup</label>
		<p> Besaran dana biaya hidup yang akan diberikan secara total. <br>Contoh biaya hidup ini seperti biaya makan, transportasi, dan tempat tinggal. </p>
		<div class="input-group col-sm-4">
			<input class="form-control" name="danaHidup" data-parsley-trigger="keyup"  data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang3" name="addon-mataUang"></span>
		</div>
	</div>

	<div class="form-group">
		<label for="nominal">Nominal Biaya Pendidikan</label>
		<p> Dana yang akan diberikan per mahasiswa </p>
		<div class="input-group col-sm-4">
			<input class="form-control" name="nominalPendidikan" data-parsley-trigger="keyup" data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang2" name="addon-mataUang2"></span>
		</div>
	</div>

	<div class="form-group">
		<label for="nominal">Nominal Biaya Hidup</label>
		<p> Dana yang akan diberikan per mahasiswa </p>
		<div class="input-group col-sm-4">
			<input class="form-control" name="nominalHidup" data-parsley-trigger="keyup" data-parsley-validation-threshold="1" data-parsley-pattern="\d|\d{1,3}(\,\d{3})*" data-parsley-maxlength="9" required>
			<span class="input-group-addon" id="addon-mataUang2" name="addon-mataUang3"></span>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="periode">Periode</label>
			<p> Periode beasiswa diberikan setiap..</p>
			<select class="form-control" name="periode" id="periode" required>
				<option selected disabled> --Pilih Periode-- </option>
				@foreach ($periode as $periode)
				<option value= {{ $periode->nama_periode}}> {{ $periode->nama_periode}} </option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="form-group">
		<label for="jangka">Jangka</label>
		<p>Berapa periode beasiswa akan diberikan?</p>
		<div class="input-group col-sm-4">
			<input type="number" placeholder="4" class="form-control" name="jangka" min= "0" data-parsley-pattern="\d*" data-parsley-type="integer" data-parsley-maxlength="3" required>
			<span class="input-group-addon" id="addon-jangka" name="addon-jangka"></span>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="tanggalBuka">Tanggal Buka</label><br>
			<input type="date" class="form-control" name="tanggalBuka" data-date-format="YYYY/MM/DD" required>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="tanggalTutup">Tanggal Tutup</label><br>
			<input type="date" class="form-control" name="tanggalTutup" data-date-format="YYYY/MM/DD" required>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-4">
			<label for="waktuTagih">Waktu Tagih</label><br>
			<p>Masukkan waktu kapan akan dilakukannya penagihan kepada pendonor</p>
			<input type="date" class="form-control" name="waktuTagih" data-date-format="YYYY/MM/DD" required>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-9">
			<label for="syarat">Syarat &nbsp;</label>
			<input type="hidden" id="arraySyarat" name="arraySyarat">
			<button type="button" class="btn btn-default" id="buttonTambahSyarat" onclick="insertRow()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
			<div class="form-group" name="syarat">
				<div class="input-group col-sm-12">
					 <br><input type = "text" class="form-control col-sm-9" name="syarat1" required><br><br>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-9">
			<label for="berkasPersyaratan">Berkas Persyaratan Pendaftaran</label><br>
			<select id="berkas" multiple="multiple" data-toggle="dropdown" name="berkas" required>
				@foreach ($berkas as $berkas)
				<option value= {{ $berkas->id_berkas}}> {{$berkas->nama_berkas}} </option>
				@endforeach
			</select>
			<input type="hidden" name="listBerkas">
		</div>
	</div>

<!-- Dibawah ini untuk field konfigurasi-penyeleksi -->
	<div>
		<h3> Konfigurasi Seleksi </h3>
	</div>

	<div class="form-group">
		<div class="input-group col-sm-9">
			<label for="jenisSeleksi">Jenis Seleksi</label><br>
			<select onchange="cekJenis(this);" class="form-control" id="jenisSeleksi" name="jenisSeleksi" required>
				<option selected disabled> --Pilih Jenis-- </option>
				@foreach ($jenisseleksi as $jenis)
				<option value= {{ $jenis->id_jenis_seleksi}}> {{$jenis->nama_jenis_seleksi}} </option>
				@endforeach
			</select>
		</div>
	</div>

	<!-- 1 -->
	<div id="fieldWebsite" class="form-group" style="display: none;">
		<label for="websiteSeleksi">Website Seleksi</label><br>
		<p>Masukkan website yang anda akan jadikan sebagai tempat untuk seleksi</p>
		<input type="text" placeholder="Website seleksi" class="form-control" name="websiteSeleksi" id="websiteSeleksi" required="">
	</div>

	<!-- 2 -->
	<div id="penyeleksi" class="form-group" style="display: none;">
		<label for="penyeleksi">Pilih Penyeleksi</label><br>
		<p>Pihak yang akan melakukan tahapan seleksi terhadap beasiswa</p>
		<div class="input-group col-sm-9">
			<select name="penyeleksi" style="overflow:auto" id=penyeleksiTahapan class="form-control" required="">
				<option selected disabled> --Pilih Penyeleksi-- </option>
				<optgroup label="PENDONOR">
					<option disabled style="color:red" class = "pendonorOpt" value="">Pilih pendonor terlebih dahulu!</option>
				</optgroup>
				<optgroup label="PEGAWAI UNIVERSITAS">
					@foreach ($pegawaiuniversitas as $pu)
					<option value= {{ $pu->id_user}}> {{$pu->nama_jabatan}} Universitas - {{$pu->nama}} </option>
					@endforeach
				</optgroup>
				<optgroup style="display: none;" class="pegawaifakultas" label="PEGAWAI FAKULTAS">
				</optgroup>
			</select>
		</div>
	</div>

	<!-- 3 -->
	<div id="tahapanSeleksi" class="form-group" style="display: none;">
		<div class="input-group col-sm-9">
			<label for="syarat">Tahapan Seleksi &nbsp;</label>
			<input value="" type="hidden" id="arrayTahapan" name="arrayTahapan">

			<div class="form-group" name="tahapanSeleksi">

				<a class="menu_links" id="tulisan3" style="display: block; cursor: pointer;" type="button" onclick="insertRowTahapan3()">+ Tambah Tes Tertulis</a>
				<a class="menu_links" id="tulisan4" style="display: block; cursor: pointer;" type="button" onclick="insertRowTahapan4()">+ Tambah Wawancara</a>

				<div id='tahapan1' class="input-group col-sm-12">
					<input style="width:220px;" type="hidden" class="form-control input" value="Tahapan seleksi di luar modul" placeholder="Nama tahapan seleksi" name="tahapan5" required="" disabled/>
				  <input style="width:220px;" type="text" class="form-control input" value="Seleksi Administratif" placeholder="Nama tahapan seleksi" name="tahapan1" required="" disabled/>
				  <span class="input-group-btn" style="width:10px;"></span>
					<p type="text" class="form-control" style="border:0;">oleh</p>
					<span class="input-group-btn" style="width:0px;"></span>
					<div class="input-sm">
						<div class="input-group col-sm-12">
							<select style="overflow:auto" class="form-control" id="penyeleksi1" name="penyeleksi1" required>
								<option selected disabled> --Pilih Penyeleksi-- </option>
								<optgroup label="PENDONOR">
									<option disabled style="color:red" class = "pendonorOpt" value="">Pilih pendonor terlebih dahulu!</option>
								</optgroup>
								<optgroup label="PEGAWAI UNIVERSITAS">
									@foreach ($pegawaiuniversitas as $pu)
									<option value= {{ $pu->id_user}}> {{$pu->nama_jabatan}} Universitas - {{$pu->nama}} </option>
									@endforeach
								</optgroup>
								<optgroup style="display: none;" class="pegawaifakultas" label="PEGAWAI FAKULTAS">
								</optgroup>
							</select>
						</div>
					</div>
				</div><br>

				<div id='tahapan2' class="input-group col-sm-12">
				  <input style="width:220px;" type="text" class="form-control input" value="Seleksi Berkas" placeholder="Nama tahapan seleksi" name="tahapan2" required="" disabled/>
				  <span class="input-group-btn" style="width:10px;"></span>
					<p type="text" class="form-control" style="border:0;">oleh</p>
					<span class="input-group-btn" style="width:0px;"></span>
					<div class="input-sm">
						<div class="input-group col-sm-12">
							<select style="overflow:auto" class="form-control" id="penyeleksi2" name="penyeleksi2" required>
								<option selected disabled> --Pilih Penyeleksi-- </option>
								<optgroup label="PENDONOR">
									<option disabled style="color:red" class = "pendonorOpt" value="">Pilih pendonor terlebih dahulu!</option>
								</optgroup>
								<optgroup label="PEGAWAI UNIVERSITAS">
									@foreach ($pegawaiuniversitas as $pu)
									<option value= {{ $pu->id_user}}> {{$pu->nama_jabatan}} Universitas - {{$pu->nama}} </option>
									@endforeach
								</optgroup>
								<optgroup style="display: none;" class="pegawaifakultas" label="PEGAWAI FAKULTAS">
								</optgroup>
							</select>
						</div>
					</div>
				</div><br>

			</div>
		</div>
	</div>
<!-- Diatas ini untuk field konfigurasi-penyeleksi -->
	<div>
		<input type="button" name="btn" value="Submit" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-success" />

		

		<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				               <b> Confirm Submit</b>
				            </div>
				            <div class="modal-body">
				                Apakah Anda yakin ingin menambahkan Beasiswa?

				            </div>

						  <div class="modal-footer">
						            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
						            <button type="submit" id="submit-form" class="btn btn-success"> Submit </button>
						           <!--  <a href="#" id="submit" class="btn btn-success success">Submit</a> -->
						  </div>
				    </div>
				</div>
		</div>
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

<div name= "alertDateModal2" class="alert alert-danger alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Tanggal Tutup Harus Lebih Besar Dari Tanggal Hari Ini</strong>
</div>
@endsection

@section('script')
<!-- script references -->>
<script type="text/javascript" src="{{ URL::asset('js/multiple-select.js') }}"></script>


<script>

  $('#berkas').multipleSelect({
		placeholder: "Pilih berkas",
		width: "100%"
	});

	function cekJenis(that){
		if(that.value=="1"){
			document.getElementById("fieldWebsite").style.display = "block";
			document.getElementById("penyeleksi").style.display = "none";
			document.getElementById("tahapanSeleksi").style.display = "none";
			$('#websiteSeleksi').attr('required',true);
			$('#penyeleksiTahapan').attr('required',false);
			$('#penyeleksi1').attr('required',false);
			$('#penyeleksi2').attr('required',false);
			$('#penyeleksi3').attr('required',false);
			$('#penyeleksi4').attr('required',false);

		}else if(that.value=="2"){
			document.getElementById("fieldWebsite").style.display = "none";
			document.getElementById("penyeleksi").style.display = "block";
			document.getElementById("tahapanSeleksi").style.display = "none";
			$('#websiteSeleksi').attr('required',false);
			$('#penyeleksiTahapan').attr('required',true);
			$('#penyeleksi1').attr('required',false);
			$('#penyeleksi2').attr('required',false);
			$('#penyeleksi3').attr('required',false);
			$('#penyeleksi4').attr('required',false);

		}else{
			document.getElementById("fieldWebsite").style.display = "none";
			document.getElementById("penyeleksi").style.display = "none";
			document.getElementById("tahapanSeleksi").style.display = "block";
			$('#websiteSeleksi').attr('required',false);
			$('#penyeleksiTahapan').attr('required',false);
			$('#penyeleksi1').attr('required',false);
			$('#penyeleksi2').attr('required',true);
			$('#penyeleksi3').attr('required',true);
			$('#penyeleksi4').attr('required',true);
		}
	}

	function cekProdi(z, idFakultas){
		//console.log("length nya: " +z);
		if(z==1){
			var p = document.getElementsByClassName("pegawaifakultas");
			var i;
			for (i = 0; i < p.length; i++) {
			    p[i].style.display = "block";
			}
			filterPegawaiFakultas(idFakultas);
		}else {
			var p = document.getElementsByClassName("pegawaifakultas");
			var i;
			for (i = 0; i < p.length; i++) {
			    p[i].style.display = "none";
			}
		}
	}

	$('#createScholarshipForm').parsley({
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

	var idTahapan;
	function insertRowTahapan3(){
		idTahapan = [1,2];
		counterT=3;
		idTahapan.push(counterT);
			document.getElementById("tulisan3").style.display = "none";
			var x = document.getElementsByName('tahapanSeleksi')[0];
	 		var elem = document.createElement('div');
	 		elem.setAttribute("id","tahapan3");
			elem.innerHTML = '<div class="input-group col-sm-12"><input style="width:220px;" type = "text" class="form-control input" value = "Tes Tertulis" name="tahapan3" required="" disabled><span class="input-group-btn" style="width:10px;"></span><p type="text" class="form-control" style="border:0;">oleh</p><span class="input-group-btn" style="width:0px;"></span><div id="penyeleksiTahapan" class="input-sm"><div class="input-group col-sm-12"><select style="overflow:auto" class="form-control" id="penyeleksi3" name="penyeleksi3"><option selected disabled> --Pilih Penyeleksi-- </option><optgroup label="PENDONOR"><option disabled style="color:red" class = "pendonorOpt" value="">Pilih pendonor terlebih dahulu!</option></optgroup><optgroup label="PEGAWAI UNIVERSITAS">@foreach ($pegawaiuniversitas as $pu)<option value= {{ $pu->id_user}}> {{$pu->nama_jabatan}} Universitas - {{$pu->nama}} </option>@endforeach</optgroup><optgroup label="PEGAWAI FAKULTAS" style="display:none;" class="pegawaifakultas"></optgroup></select></div></div><span class="input-group-btn"><button class="btn btn-danger" onclick="removeTahapan3()"> x </button></span><br><br>';
	 		x.appendChild(elem);

				var idPendonor = $("#pendonor").val();
				var pendonor = $("#pendonor").find('option:selected').text()
				if (idPendonor!=null) {
					$(".pendonorOpt").val(idPendonor);
					$(".pendonorOpt").html(pendonor);
					$(".pendonorOpt").removeAttr("disabled");
					$(".pendonorOpt").removeAttr("style");
				}
	}

	function insertRowTahapan4(){
		counterT=4;
		idTahapan.push(counterT);
			document.getElementById("tulisan4").style.display = "none";
			var x = document.getElementsByName('tahapanSeleksi')[0];
	 		var elem = document.createElement('div');
	 		elem.setAttribute("id","tahapan4");
			elem.innerHTML = '<div class="input-group col-sm-12"><input style="width:220px;" type = "text" class="form-control input" value = "Wawancara" name="tahapan4" required="" disabled><span class="input-group-btn" style="width:10px;"></span><p type="text" class="form-control" style="border:0;">oleh</p><span class="input-group-btn" style="width:0px;"></span><div id="penyeleksiTahapan" class="input-sm"><div class="input-group col-sm-12"><select style="overflow:auto" class="form-control" id="penyeleksi4" name="penyeleksi4"><option selected disabled> --Pilih Penyeleksi-- </option><optgroup label="PENDONOR"><option disabled style="color:red" class = "pendonorOpt" value="">Pilih pendonor terlebih dahulu!</option></optgroup><optgroup label="PEGAWAI UNIVERSITAS">@foreach ($pegawaiuniversitas as $pu)<option value= {{ $pu->id_user}}> {{$pu->nama_jabatan}} Universitas - {{$pu->nama}} </option>@endforeach</optgroup><optgroup label="PEGAWAI FAKULTAS" style="display:none;" class="pegawaifakultas"></optgroup></select></div></div><span class="input-group-btn"><button class="btn btn-danger" onclick="removeTahapan3()"> x </button></span><br><br>';
	 		x.appendChild(elem);

				var idPendonor = $("#pendonor").val();
				var pendonor = $("#pendonor").find('option:selected').text()
				if (idPendonor!=null) {
					$(".pendonorOpt").val(idPendonor);
					$(".pendonorOpt").html(pendonor);
					$(".pendonorOpt").removeAttr("disabled");
					$(".pendonorOpt").removeAttr("style");
				}
	}

	function removeTahapan3(){
			document.getElementById("tulisan3").style.display = "block";
		var j;
		$("#tahapan3").remove();
		for (j = 0; j < idTahapan.length; j++) {
			console.log(idTahapan[j] + " " + 3);
			if (idTahapan[j] == 3)
			{
				 if (j == idTahapan.length)
				 {
					 idTahapan.pop();
				 }
				 else{
					 idTahapan.splice(j, 1);
				 }
				 break;
 			}
 		}
 		console.log(idTahapan);
 	}

	function removeTahapan4(){
			document.getElementById("tulisan4").style.display = "block";
		var j;
		$("#tahapan4").remove();
		for (j = 0; j < idTahapan.length; j++) {
			console.log(idTahapan[j] + " " + 4);
			if (idTahapan[j] == 4)
			{
				 if (j == idTahapan.length)
				 {
					 idTahapan.pop();
				 }
				 else{
					 idTahapan.splice(j, 1);
				 }
				 break;
 			}
 		}
 		console.log(idTahapan);
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
		document.getElementsByName('arrayTahapan')[0].value = idTahapan;

		var x = $('#fakultasBeasiswa').multipleSelect('getSelects');

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

			fillProdi(jenjang);
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

	function filterPegawaiFakultas(idFakultas)
	{
		$.ajax({
			type:'POST',
			url:'filter-pegawai-fakultas',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
			'idFakultas': idFakultas},
			success:function(data){
				$(".pegawaifakultas").empty();
				$.each(data, function(i,item){
					$('.pegawaifakultas').append(
						$('<option value="' + data[i].id_user + '">' + data[i].nama_jabatan + ' - ' + data[i].nama_fakultas+ ' - ' + data[i].nama +'</option>')
					);
				});
			},
			 	error: function(data){
    	 	alert("fail");
    	}
		});
	}
</script>
@endsection
