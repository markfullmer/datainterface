<?php

require '../../../vendor/autoload.php';
require '../../head.php';

use markfullmer\datainterface\DataInterface;

$app = new DataInterface([
  'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSWSYrm08X2aZ9IeTS2dKRvyM_6Jp3_zMPDfuILHkbyUKkUgQpwxzI8upQPz3OR76PqZHYO8BaFmsdc/pub?output=csv',
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
<?php
require '../../foot.php';
