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
</body>
</html>
