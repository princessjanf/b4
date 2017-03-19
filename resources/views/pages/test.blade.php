<html>
<head>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
</head>
<body>
  <button onclick="deleteBeasiswa()">delete</button>
</body>
  <script>
      function deleteBeasiswa(){
        $.ajax({
              type:'GET',
              url:'localhost:8000/delete/',
              data:{'_token': <?php echo csrf_token() ?>,
                    'id':2
              },
              success:function(data){
              }

           });
      }
  </script>

</html>
