<html>
<style>
ul {list-style-type: none;}
body {font-family: Verdana, sans-serif;}

/* Month header */
.month {
    padding: 70px 25px;
    width: 100%;
    text-align: center;
}

/* Month list */
.month ul {
    margin: 0;
    padding: 0;
}

.month ul li {
    color: #1abc9c;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
}

/* Previous button inside month header */
.month .prev {
    float: left;
    padding-top: 10px;
}

/* Next button */
.month .next {
    float: right;
    padding-top: 10px;
}

/* Weekdays (Mon-Sun) */
.weekdays {
    margin: 0;
    padding: 10px 0;
    background-color:#ddd;
}

.weekdays li {
    display: inline-block;
    width: 13.6%;
    color: #666;
    text-align: center;
}

/* Days (1-31) */
.days {
    padding: 10px 0;
    background: #eee;
    margin: 0;
}

.days li {
    list-style-type: none;
    display: inline-block;
    width: 13.6%;
    text-align: center;
    margin-bottom: 5px;
    font-size:12px;
    color: #777;
}

/* Highlight the "current" day */
.days li .active {
    padding: 5px;
    background: #1abc9c;
    color: white !important
}
</style>
<div class = 'row'>
  <div class="month">
  <ul>
    <li class="prev">&#10094;</li>
    <li class="next">&#10095;</li>
    <li><?= date("F") ?><br><span style="font-size:18px"><?= date("Y") ?></span></li>
  </ul>
</div>

<ul class="weekdays">
  <li>Su</li>
  <li>Mo</li>
  <li>Tu</li>
  <li>We</li>
  <li>Th</li>
  <li>Fr</li>
  <li>Sa</li>
</ul>
<ul class="days"> 
  <?php $i = date('N',mktime(0, 0, 0, date('m'), 1)) - 6;   ?>
  
  <?php while($i <= date("t")) : $recipe = false;?>

    <li>
        
      <?php foreach($calendar as $date) : ?>
        <?php if($date['day'] == $i) : $recipe = true; ?>
           <a href = "<?= $this->Url->build([
               "controller" => "Recipes",
               "action" => "arecipe",
               $date['recipe'],
           ]); ?>"><span class="active"><?= $date['recipe_name'] ?></span></a>
        <?php endif ?>
      <?php endforeach ?>
      <?php if($recipe == false) : ?>
        <?= $i ?>
      <?php endif ?>
    </li>

    <?php $i++ ?>
  <?php endwhile; ?>
</ul>
</div>
