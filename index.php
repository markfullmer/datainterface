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
  $artists[] = trim($record['Artist']);
}
$artists = array_unique($artists);

echo '<form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">';
echo '<select name="artist">';
foreach ($artists as $i) {
  echo '<option value="' .  $i. '">' . $i . '</option>';
}
echo '</select>';
echo '<input type="submit" value="Filter by artist"><button><a href="//' . $_SERVER['SERVER_NAME'] . '">Reset</a></button></form>';

if (isset($_POST['artist'])) {
  $artist = $_POST['artist'];
}

echo '<table><thead><th>Artist</th><th>Title</th><th>Year</th><th>Label</th><th>Genre</th><th>Cover Art</th></thead>';
foreach ($records as $record) {
  if (isset($artist) && $record['Artist'] !== $artist) {
    continue;
  }
  echo '<tr><td>' . $record['Artist'] . '</td><td>' . $record['Title'] . '</td><td>' . $record['Year'] . '</td><td>' . $record['Label'] . '</td><td>' . $record['Genre'] . '</td><td><img src="' . $record['Image'] . '" width="200" height="200" /></td></tr>';
}
echo '</table>';
