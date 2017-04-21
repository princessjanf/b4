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

<button onclick="saveDraft()"> Save As Draft </button>

<button> Finalize Result </button>

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
			alert("Nilai sementara berhasil disimpan!");
		}
	});
}
</script>
<style>
#fix {
    position: fixed;
    top: 8em;
    right: 15em;
}

</style>
@endsection
