<?php

require '../../../vendor/autoload.php';
require '../../head.php';

?>
<div class="container">
  <div class="row">
    <form method="POST" action="interface.php">
      <div><label>URL to CSV:<input type="text" name="url" value="https://docs.google.com/spreadsheets/d/e/2PACX-1vQJx7hxkTebbnwzTCKjKxK0IFHCD6wEOTvS3qzZy8sH6woRJcaS0xc4zbM/pub?gid=1853055217&single=true&output=csv" /></label></div>
      <div><label>Columns eligible for filtering (comma-separated):<input type=" text" name="filters" value="category" /></label></div>
      <div><label>Columns to display in table (comma-separated):<input type="text" name="table" value="word,first definition,second definition,source" /></label></div>
      <div><label>Interface Title<input type=" text" name="title" value="Vocabulary List" /></label></div>
      <input type="hidden" name="reset" value="1" />
      <div><input type="submit" name="submit" value="Build interface"></div>
    </form>
  </div>
</div>
<?php
require '../../foot.php';
