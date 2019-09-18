<html>
  <div class = "row">
    Your driver will be using the following store: <?= $store['0']->name ?> Located at latitude <?= $store['0']->latitude ?> and longitude <?= $store['0']->longitude ?>
  </div>
  <div class = "row">
    The time to drive from this wegmans to your address is <?= $driving_time ?>
  </div>
  <div class = "row">
    The estimated price for an uber driver to pick up your groceries would be $<?= $price ?>
  </div>
</html>
