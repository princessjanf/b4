@extends('master')

@section('title', 'Seleksi Beasiswa')

@section('head')
<link href="{{ asset('css/multiple-select.css') }}" rel="stylesheet" />
@endsection

@section('content')
<!-- user : username, name, role
	pengguna : username, nama, email
	namarole
	idtahapan
	idbeasiswa
	pendaftar: id_mahasiswa, nilai_seleksi, final, nama
-->

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
			<td>
				<input type = "number" id="{{$pendaftar->id_mahasiswa}}" name = "{{$pendaftar->id_mahasiswa}}" value= "{{$pendaftar->nilai_seleksi}}" min="0" max="100">
			</td>
		</tr>
		@endforeach

		<!--
			@for ($i = 0; $i < 15; $i++)
			<tr>
			<td>1</td>
			<td>
			a
			</td>
			<td>
			<input type = "number" value= "2" min="0" max="100">
			</td>

			</tr>


			@endfor
		-->
	</tbody>
</table>

<div id="savedraf" name= "alertSaveDraft" class="alert alert-dismissable fade in">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong>Nilai sementara berhasil disimpan</strong>
</div>
<div id = "fix">
	<button onclick="saveDraft()"> Save As Draft </button>
</div>
<button onclick="showResult()"> Finalize Result </button>

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

		//$('#resultConfirmationModal').find('.modal-body #jumlahChecked').text = 1;
	});
	function saveDraft(){
		var table = $('#tableSeleksi').DataTable().$('input').serialize();
		console.log({{$pengguna->id_user}});
		$.ajax({
			type:'POST',
			url:'/save-draft',
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

		var table = $('#tableSeleksi').DataTable().$('input').serialize();
		$.ajax({
			type:'POST',
			url:'/save-draft',
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
								url:'/retrieve-nama',
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



		// Ke page baru untuk ngasih liat list yang keterima berdasarkan nilai tertinggi
		// They can make final selection by nge undo tick atau ngasih tick
		// trus klik finalize result
		// ada limitasi kuota
		// informasi yang harus dikirim: Nama pendaftar, Nilai tertinggi yang ada disini

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
			url:'/finalize-result',
			dataType:'json',
			data:{'_token' : '<?php echo csrf_token() ?>',
				'table': arrayResult,
				'idtahapan': {{$idtahapan}},
				'idbeasiswa': {{$idbeasiswa}},
				'pengguna': {{$pengguna->id_user}}
			},
			success:function(data){
				console.log(data);
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
    right: 5em;
	}

</style>
@endsection
