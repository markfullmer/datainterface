<?php

use League\Csv\Reader;
use League\Csv\Statement;

require 'vendor/autoload.php';
require 'head.html';

$csv = Reader::createFromPath('data.csv', 'r');
$csv->setHeaderOffset(0); //set the CSV header offset
$stmt = Statement::create();
$records = $stmt->process($csv);

$artists = [];
foreach ($records as $record) {
  $artists[] = trim($record['Composer']);
}
$artists = array_unique($artists);

echo '<form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">';
echo '<select name="artist">';
echo '<option value="">All</option>';
foreach ($artists as $i) {
  echo '<option value="' .  $i. '">' . $i . '</option>';
}
echo '</select>';
echo '<input type="submit" value="Filter by composer"><button><a href="//' . $_SERVER['SERVER_NAME'] . '">Reset</a></button></form>';

if (isset($_POST['artist'])) {
  $artist = $_POST['artist'];
}

echo '<table><thead><th>Composer</th><th>Title</th><th>Year</th></thead>';
foreach ($records as $record) {
  if (isset($artist) && $artist !== "" && $record['Composer'] !== $artist) {
    continue;
  }
  $td = [];
  $td[] = '<tr><td>' . $record['Composer'] . '</td>';
  $td[] = '<td>' . $record['Title'] . '</td>';
  $td[] = '<td>' . $record['Copyright'] . '</td></tr>';
  echo implode($td);
}
echo '</table>';
