<?php

require 'vendor/autoload.php';
require 'head.html';

use markfullmer\datainterface\DataInterface;

$app = new DataInterface('data.csv', [
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
