<?php

require '../../../vendor/autoload.php';
require '../../head.php';

use markfullmer\datainterface\DataInterface;

$app = new DataInterface([
  'url' => 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSXeHxdsSr4XITFCh1bGzad1-_hCBx5sAk5wdZ0cCm1yr36X12x-JNGQIj7rN-t2MT6gP_yDdov4Ihq/pub?gid=0&single=true&output=csv',
  'title' => 'Corpus of Short Story Openings',
  'filters' => ['Author', 'Opening Technique', 'Tense', 'Voice'],
  'table_columns' => ['Author', 'Title', 'Opening Technique', 'Voice', 'Tense', 'First Paragraph'],
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
