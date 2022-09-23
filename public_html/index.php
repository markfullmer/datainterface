<?php
require '../vendor/autoload.php';
require 'head.php';

$markdown = file_get_contents('../README.md');
$parser = new Parsedown();
echo '<div class="container">';
echo $parser->text($markdown);
echo '</div>';
