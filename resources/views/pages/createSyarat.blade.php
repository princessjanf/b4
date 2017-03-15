@extends('main')

@section('title', '| Create Scholarship')

@section('nav.home')
class="active"
@endsection

@section('body')

	<table class="w3-table" id ="tableSyarat">
		<thead>
			<tr>
				<th>Syarat</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td> <input type = "text" id="syarat1"> </td>
			</tr>
		</tbody>
    <button type="button" class="btn btn-default pull-right" id="butTambahBahan" onclick="insertRow()">Tambah Bahan</button>
	</table>
	<button type="submit" class="btn btn-default">Submit</button>
</form>
</div>
@endsection
<script>
function insertRow(){

		var tmp = document.getElementById('tableSyarat');
		var new_row = tmp.rows[1].cloneNode(true);
		new_row.cells[0].innerHTML =
		'<div class="dropdown">'+
		'<select id = "bahanMakanan'+counter+
		'" class="btn  w3-btn w3-hover-red dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button></select></div>';
    tmp.appendChild(new_row);
		}

	}
</script>
