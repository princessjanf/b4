<html>
<head>
</head>
<body>
  <form id='createScholarshipForm' action = "/insertScholarship" method = "post" data-parsley-validate="">
  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
  <input type = "hidden" name = "counter" value="1">
  <table class="w3-table" id ="tableSyarat">
					<thead>
						<tr>
							<th>Syarat</th>
            </tr>
					</thead>
					<tbody>
						<tr>
						<td>
							<input type = "text" id="syarat1">
						</td>
				</tr>
			</tbody>
		</table>
    <input type='submit'>
  </form>
    <div>
        <button type="button" class="btn btn-default pull-right" id="buttonTambahSyarat" onclick="insertRow()">+</button>
    </div>
</div>
<script>
counter=1;
function insertRow(){
    counter+=1;
    console.log(counter);
    
		var tmp = document.getElementById('tableSyarat');
		var new_row = tmp.rows[1].cloneNode(true);
		new_row.cells[0].innerHTML =
    '<input type = "text" id="syarat1">';
		tmp.appendChild(new_row);
	}
</script>
</body>
</html>
