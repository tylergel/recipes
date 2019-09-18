<html>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<div class = "recipe card col-md-8 offset-md-2">
  <div class = 'card-title'>
    <?= $response->name ?>
    
     <a href = "<?= $this->Url->build([
               "controller" => "Recipes",
               "action" => "delete",
               $id,
           ]); ?>">
         <i id = '<?= $id ?>' class=" fa fa-trash pull-right" aria-hidden="true" >delete</i>
         </a>
  </div>
  <img class = 'card-img-top col-md-6' src = <?=$response->_links[2]->href; ?>><br>
  <div class = 'card-body'>

        Preperation time: <?= $response->preparationTime->min; ?><br>
        Cooking time: <?= $response->cookingTime->min; ?>

  </div>
  <div class = 'card-body'>

        Ingredients<br>
      <?php foreach($response->ingredients as $ing) : ?>
        -<?= $ing->name;  ?> <br>
      <?php endforeach ?>

  </div>
  <div class = 'row col-md-12 card-body'>
    <br>
      <p class = "text-center">Instructions</p><br>
      <?php $i = 0; foreach($response->instructions as $ing) : ?>
        <?php if($i > (count((array)$response->instructions) )-3) { break; } $i++; echo $ing; ?> <br>
      <?php endforeach ?>

    </div>
  </div>
</div>

</html>
