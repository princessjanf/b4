<html>
<head>
</head>
<body>
  <form id='createScholarshipForm' action = "/insertScholarship" method = "post" data-parsley-validate="">
  <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
  <head>
    <link href="multiple-select.css" rel="stylesheet"/>
</head>
<body>
    <select multiple="multiple">
        <optgroup label="Group 1">
            <option value="1">Option 1</option>
            ...
        </optgroup>
        ...
        <optgroup label="Group 3">
            ...
            <option value="9">Option 9</option>
        </optgroup>
    </select>
    <script src="multiple-select.js"></script>
    <script>
        $('select').multipleSelect();
    </script>
</body>
    <button type='submit'>submit</button>
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
    document.getElementsByName("counter")[0].value = counter;
		var tmp = document.getElementById('tableSyarat');
		var new_row = tmp.rows[1].cloneNode(true);
		new_row.cells[0].innerHTML =
    '<input type = "text" name="syarat">';
		tmp.appendChild(new_row);
	}
</script>
</body>
</html>
