@extends('master')

@section('title', 'Seleksi Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<h4> Lihat Tahapan {{$tahapan->nama_tahapan}} </h4>
<a href = "{{ url('seleksi/'.$idbeasiswa) }}">  Kembali Ke Daftar Tahapan  </a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
@if($final=='2')
<a href = "{{ url('nama-penerima/'.$idbeasiswa) }}">  Lihat Penerima Beasiswa  </a>
@elseif($final == '0')
<a href = "{{ url('/pendaftar-beasiswa/'.$idbeasiswa) }}">  Lihat Pendaftar Beasiswa  </a>
@endif
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
				<button type='button' id="submitResult" class='btn btn-default' onclick="finalizeResult()">Submit</button>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			</div>
		</div>
	</div>
</div>
<table id='tableSeleksi' class="table table-striped col-sm-8">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Pendaftar</th>
			<th>Nilai Seleksi</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($pendaftar as $index => $pendaftar)
		<tr>
			<td>{{$index+1}}</td>
			<td>
					{{$pendaftar->nama}}
			</td>
			@if ($final == 2)
			<td>
				{{$pendaftar->nilai_seleksi}}
			</td>

			@elseif ($final == 0)
			<td>
				<input type = "number" id="{{$pendaftar->id_mahasiswa}}" name = "{{$pendaftar->id_mahasiswa}}" value= "{{$pendaftar->nilai_seleksi}}" min="0" max="100">
			</td>
			@endif
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
@if($final == 0)
<div id = "fix">
</div>
<button class="btn-primary" onclick="saveDraft()"> Save As Draft </button>
<button class="btn-success" onclick="showResult()"> Finalize Result </button>
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


	});
	function saveDraft(){
		var table = $('#tableSeleksi').DataTable().$('input').serialize();
		console.log(table);
		$.ajax({
			type:'POST',
			url:'{{url('/save-draft')}}',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
				'table': table,
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

	$("#resultConfirmationModal").change(function(){
		$("#resultConfirmationModal .modal-body #jumlahChecked").text(document.querySelectorAll('input[type="checkbox"]:checked').length);
		if(document.querySelectorAll('input[type="checkbox"]:checked').length > {{$beasiswa->kuota}}){
			$('#resultConfirmationModal').find('.modal-footer #alertChecked').show();
			$('#resultConfirmationModal .modal-footer #submitResult').attr("disabled", true);
		}
		else if(document.querySelectorAll('input[type="checkbox"]:checked').length == 0)
		{
			$('#resultConfirmationModal').find('.modal-footer #alertChecked2').show();
			$('#resultConfirmationModal .modal-footer #submitResult').attr("disabled", true);
		}
		else{
			$('#resultConfirmationModal .modal-footer #submitResult').attr("disabled", false);
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
		var table = $('#tableSeleksi').DataTable().$('input').serialize();
		$.ajax({
			type:'POST',
			url:'{{url('/save-draft')}}',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
				'table': table,
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
								console.log(nama);

								count=+1;
								if(count<={{$beasiswa->kuota}}){
									html = html + '<tr><td class="idMahasiswa" id='+datum[0]+'>' + nama + '</td><td> <input type="checkbox" class="chk" value='+datum[0]+' checked> Diterima </td></tr>';
								}
								else{
									html = html + '<tr><td class="idMahasiswa">' + nama + '</td><td> <input type="checkbox" class="chk" value='+datum[0]+'> </td></tr>';
								}
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
		$('#resultConfirmationModal .modal-body #resultTable .idMahasiswa').each(function(i, val){

			// Find the previous sibling (td) and then find the input inside and see if it's checked
			var checkbox_cell_is_checked = $(this).next().find('input').is(':checked');
			// Is it checked?
			if(checkbox_cell_is_checked){
				arrayResult.push($(this).attr('id'));
			}
		});

		$.ajax({
			type:'POST',
			url:'{{url('/finalize-result')}}',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
				'table': arrayResult,
				'idtahapan': {{$idtahapan}},
				'idbeasiswa': {{$idbeasiswa}},
				'pengguna': {{$pengguna->id_user}}
			},
			success:function(data){
				window.location.href = "{{ url('seleksi-beasiswa/'.$idbeasiswa.'/'.$idtahapan) }}";
			},
			error: function(xhr, textStatus, errorThrown) {
				alert(xhr.responseText);
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
