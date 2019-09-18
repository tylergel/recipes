<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<div class = "row text-center mt-3">
   <h1> Wegman's Recipes</h1>
</div>
<div class = "row text-center mt-2">
    <?= $this->Html->link(
      'View Cart',
      '/recipes/cart',
      ['class' => 'button']
  ); ?>
    <?= $this->Html->link(
      'View Weekly Schedule',
      '/recipes/schedule',
      ['class' => 'button']
  ); ?>
</div>
<?php $i = 0; ?>
<?php foreach($responses as $response) :   ?>
  <div data-recipe = "<?= $response->id ?>" class = "recipe card col-md-4">
    <div class = 'card-title text-center'>
      <a href = <?= $this->Url->build([
          "controller" => "Recipes",
          "action" => "addrecipe",
          $response->id,
      ]); ?>><button><i class="fa fa-plus-circle" aria-hidden="true">Add Recipe to calendar</i></button></a>
    </div>
    <img class = 'card-img-top' src = <?=$response->_links[2]->href; ?>><br>
    <div class = 'card-body text-center'>

      <a><?= $response->name ?></a>
      <div id = '<?= $response->id ?>' class = "card-title" style = "display: none">
        <div id= '<?= $response->id; ?>' class = 'add card-title'>
          <a><i class="fa fa-plus-circle" aria-hidden="true">Add Ingredients</i></a>
        </div><br>
        <?php foreach($response->ingredients as $ing) : ?>
          <?= $ing->name;  ?> <br>
        <?php endforeach ?>

      </div>
    </div>
  </div>
<?php $i++; ?>
<?php endforeach ?>
</html>
<script>

$( ".recipe" ).click(function() {
  id = '#';
  id += $(this).attr('data-recipe');
  $(id).toggle();

});

$( ".add" ).click(function() {
  id = $(this).attr('id');
  var thing = '/recipes/recipes/add/';
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
