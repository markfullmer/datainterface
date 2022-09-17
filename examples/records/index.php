<?php

require '../../vendor/autoload.php';
require '../../head.html';

use markfullmer\datainterface\DataInterface;

$app = new DataInterface('records.csv', [
  'title' => 'List of LPs',
  'filters' => ['Artist', 'Year', 'Genre'],
  'table_columns' => ['Artist', 'Title', 'Year', 'Label', 'Genre'],
]);
?>

<div class="container">
  <div class="row">
    <?php
    if (!empty($app->options['title'])) {
      echo '<h1>' . $app->options['title'] . '</h1>';
    }
    ?>
    <?php echo $app->buildForm(); ?>
    <?php echo $app->buildTable(); ?>
  </div>
</div>
