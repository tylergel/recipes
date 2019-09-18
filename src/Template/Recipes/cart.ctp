<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<div class = "row text-center mt-3">
  <h1>Your cart</h1>
</div>
<?php foreach($usersCartArray as $item) : ?>
<div class = "row col-md-8 ">
  <?= $item['item_name']; ?> <a> <i id = '<?= $item['id']; ?>' class="remove fa fa-minus-circle pull-right" aria-hidden="true" ></i></a>
</div>
<?php endforeach ?>
</html>
<script>
$( ".remove" ).click(function() {
  id = $(this).attr('id');
  var thing = 'remove/';
  thing += id;
  $.ajax({
      url : thing,
      type: 'POST',
      success : function(response){
        location.reload();
      }
  });
});
</script>
