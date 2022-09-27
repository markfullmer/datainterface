<?php

require '../../../vendor/autoload.php';
require '../../head.php';

use markfullmer\datainterface\DataInterface;

if (!isset($_POST['url'])) {
  header('Location: ./index.php');
  die();
}
$url = $_POST['url'];
$title = $_POST['title'];
$filters = explode(',', $_POST['filters']);
$table_columns = explode(',', $_POST['table']);
$app = new DataInterface([
  'url' => $url,
  'title' => $title,
  'filters' => $filters,
  'table_columns' => $table_columns,
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
