@extends('master')

@section('title', 'Seleksi Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<h4> Lihat Tahapan {{$tahapan->nama_tahapan}} </h4>
<a href = "{{ url('seleksi') }}">  Kembali Ke Daftar Seleksi  </a>
</br>
</br>
@if($final=='2')
<a href = "{{ url('nama-penerima/'.$idbeasiswa) }}">  Lihat Penerima Beasiswa  </a>
@elseif($final == '0')
<a href = "{{ url('/pendaftar-beassiswa/'.$idbeasiswa) }}">  Lihat Pendaftar Beasiswa  </a>

@endif
</br>
</br>
</br>
@if ($final == '1' )
<h3> Tidak ada mahasiswa yang dapat diseleksi untuk tahapan ini </h4>
<h4> Hal ini bisa terjadi karena tidak ada mahasiswa yang mendaftar atau seleksi tahap sebelumnya belum selesai </h4>
@else
<div class='modal fade' id='resultConfirmationModal' role='dialog'>
	<div class='modal-dialog'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal'></button>
				<h4 class='modal-title'>Penerima Beasiswa</h4>
			</div>
			<div class='modal-body'>
					<p> Terpilih
					<span id="jumlahChecked"> </span>
					dari kuota {{$beasiswa->kuota}} mahasiswa </p>

			</div>
			<div class='modal-footer'>
				<div  id= "alertChecked" class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Pilihan Mahasiswa Melebihi Kuota!</strong>
				</div>
				<div  id= "alertChecked2" class="alert alert-danger alert-dismissable fade in">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<strong>Tidak ada mahasiswa yang dipilih!</strong>
				</div>
				<button type='button' id="submitResult" class='btn btn-default' onclick="finalizeResult()">Kirim</button>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>
			</div>
		</div>
	</div>
</div>

<table id='tableSeleksi' class="table table-striped col-sm-8">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Pendaftar</th>
			<th>Hasil Seleksi</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($pendaftar as $index => $pendaftar)
		<tr>
			<td>{{$index+1}}</td>
			<td>
					{{$pendaftar->nama}}
			</td>
			<td>
				@if($final == 0)
						@if ($pendaftar->nilai_seleksi == 1)
						<input type="checkbox" class="chk" id="{{$pendaftar->id_mahasiswa}}" checked> Diterima
						@else
						<input type="checkbox" class="chk" id="{{$pendaftar->id_mahasiswa}}"> Diterima
						@endif
				@elseif ($final == 2)
						@if ($pendaftar->nilai_seleksi == 0)
						 Ditolak
						@else
						 Diterima
						@endif
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<div id="savedraf" name= "alertSaveDraft" class="alert alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Nilai sementara berhasil disimpan</strong>
</div>
<div id="waktudaftar" name= "alertWaktuDaftar" class="alert alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Masa pendaftaran belum selesai</strong>
</div>
<div  id= "alertCheck" class="alert alert-danger alert-dismissable fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Pilihan Mahasiswa Melebihi Kuota!</strong>
</div>
<div  id= "alertCheck2" class="alert alert-danger alert-dismissable fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Tidak ada mahasiswa yang dipilih!</strong>
</div>
@if($final == 0)
<div id = "fix">
	<p> Terpilih
	<span id="kuotaChecker"> </span>
	dari </br>  {{$beasiswa->kuota}} mahasiswa </p>
	<button class="btn-primary" onclick="saveDraft()"> Simpan Sebagai Draf </button>
</div>
<button id="showResult" class="btn-success" onclick="showResult()"> Finalisasi Hasil </button>
@endif
@endif

@endsection

@section('script')
<script src="{{ asset('js/jquery-3.2.0.js') }}"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<script src="{{ asset('js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap.js') }}"></script>
<script>

	$(document).ready(function() {
		$('#tableSeleksi').DataTable();
		$("[name='alertSaveDraft']").hide();
		$("[name='alertWaktuDaftar']").hide();
		$("#alertCheck").hide();
		$("#alertCheck2").hide();
		$("#fix #kuotaChecker").text(document.querySelectorAll('input[type="checkbox"]:checked').length);
		if(document.querySelectorAll('input[type="checkbox"]:checked').length > {{$beasiswa->kuota}} || document.querySelectorAll('input[type="checkbox"]:checked').length == 0 ){
			$('#showResult').attr("disabled", true);
		}
	});

	function saveDraft(){
				var arrayResult = [];
				$('#tableSeleksi .chk').each(function(i, val){
					var checkbox_cell_is_checked = $(this).is(':checked');
					if(checkbox_cell_is_checked){
						arrayResult.push($(this).attr('id'));
					}
				});

				console.log(arrayResult);
			$.ajax({
				type:'POST',
				url:'{{url('/save-draft-check')}}',
				dataType:'json',
				data:{'_token' : '<?php echo csrf_token() ?>',
					'table': arrayResult,
					'idtahapan': {{$idtahapan}},
					'idbeasiswa': {{$idbeasiswa}},
					'pengguna': {{$pengguna->id_user}}
				},
				success:function(data){
					console.log(data.msg[0]);
					alert("Nilai sementara berhasil disimpan!");
				}
			});
	}

	$("#tableSeleksi").change(function(){
		$("#fix #kuotaChecker").text(document.querySelectorAll('input[type="checkbox"]:checked').length);
		if(document.querySelectorAll('input[type="checkbox"]:checked').length > {{$beasiswa->kuota}}){

			$('#alertCheck').show();
			$('#showResult').attr("disabled", true);
		}
		else if(document.querySelectorAll('input[type="checkbox"]:checked').length == 0)
		{
			$('#showResult').attr("disabled", true);
		}
		else{
			$('#showResult').attr("disabled", false);
		}
	});



	function showResult(){

		var x = "{{$beasiswa->tanggal_tutup}}".split('-');
		var now = new Date();
		var tgl = new Date().setFullYear(x[0], x[1]-1, x[2]-1);

		if (tgl > now)
		{
			$("[name='alertWaktuDaftar']").show();
		}
		else{
			var arrayResult = [];
			$('#tableSeleksi .chk').each(function(i, val){
				var checkbox_cell_is_checked = $(this).is(':checked');
				if(checkbox_cell_is_checked){
					arrayResult.push($(this).attr('id'));
				}
			});
		$.ajax({
			type:'POST',
			url:'{{url('/save-draft-check')}}',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
				'table': arrayResult,
				'idtahapan': {{$idtahapan}},
				'idbeasiswa': {{$idbeasiswa}},
				'pengguna': {{$pengguna->id_user}}
			},
			success:function(data){
				var html='';
				var count=0;
				html+='<table id="resultTable" name="resultTable" class="table"><thead><tr><th>Nama</th><th>Status Penerimaan</th></tr></thead><tbody>';
				var nama='';
				$.each(data, function(i,item){
					$.each(item, function(j,datum){
						$.ajax({
							async:false,
							type:'POST',
							url:'{{url('/retrieve-nama')}}',
							dataType:'json',
							data:{'_token' : '<?php echo csrf_token() ?>',
								'id_user': datum[0]
							},
							success:function(data){
								nama = data.msg.nama;
								html = html + '<tr><td class="idMahasiswa" id='+datum[0]+'>' + nama + '</td><td> Diterima </td> </tr>';
								count++;
						}
					});
					});
				});
				 html = html+ '</tbody></table>'

				$('#resultConfirmationModal').find('.modal-body').append(html);
				$("#resultConfirmationModal .modal-body #jumlahChecked").text(count);
				$('#resultConfirmationModal').find('.modal-footer #alertChecked').hide();
				$('#resultConfirmationModal').find('.modal-footer #alertChecked2').hide();
				$('#resultConfirmationModal').modal('show');
			}
		});
	}
	}
	function finalizeResult(){


		var arrayResult = [];
		$('#tableSeleksi .chk').each(function(i, val){
			var checkbox_cell_is_checked = $(this).is(':checked');
			if(checkbox_cell_is_checked){
				arrayResult.push($(this).attr('id'));
			}
		});
		console.log(arrayResult);

		$.ajax({
			type:'POST',
			url:'{{url('/finalize-result-checked')}}',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
				'table': arrayResult,
				'idtahapan': {{$idtahapan}},
				'idbeasiswa': {{$idbeasiswa}},
				'pengguna': {{$pengguna->id_user}}
			},
			success:function(data){
				window.location.href = "{{ url('seleksi-luar/'.$idbeasiswa) }}";
				console.log(data);
			},
			error: function(xhr, textStatus, errorThrown) {

			}
		});
	}
	$("#resultConfirmationModal").on("hidden.bs.modal", function(){
		$("#resultConfirmationModal .modal-body").html("");
	});
</script>
<style>
	#fix {
    position: fixed;
    top: 8em;
    right: 3em;
	}

</style>
@endsection
