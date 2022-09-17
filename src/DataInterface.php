<?php

namespace markfullmer\datainterface;

use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\ResultSet;

/**
 * Application View logic.
 */
class DataInterface {

  public string $file;

  public array $options = [
    'filters' => [],
    'table_columns' => [],
    'title' => '',
  ];

  public array $filters;

  public ResultSet $records;


  /**
   * Class constructor.
   *
   * @param string $file
   *    The path to the CSV file of data.
   * @param array $options
   *    Display options for the form.
   */
  public function __construct($file, $options) {
    $this->file = $file;
    $this->options = $options;
    $reader = Reader::createFromPath($this->file, 'r');
    $reader->setHeaderOffset(0);
    $this->records = Statement::create()->process($reader);
    $this->filters = $this->buildFilters();
  }

  public function buildTable() {
    $output = [];
    $output[] = '<div id="table">';

    if (isset($_POST['author'])) {
      $author = $_POST['author'];
    }
    if (isset($_POST['focus'])) {
      $focus = $_POST['focus'];
    }
    if (isset($_POST['tense'])) {
      $tense = $_POST['tense'];
    }
    if (isset($_POST['voice'])) {
      $tense = $_POST['voice'];
    }
    $output[] = '<table><thead>';
    foreach ($this->records->getHeader() as $header) {
      if (in_array($header, $this->options['table_columns'])) {
        $output[] = '<th>' . $header . '</th>';
      }
    }
    $output[] = '</thead>';
    foreach ($this->records as $record) {
      $print = TRUE;
      foreach ($record as $key => $value) {
        if (array_key_exists($key, $this->filters)) {
          $hash = md5($key);
          if (!empty($_POST[$hash]) && strpos($value, $_POST[$hash]) === FALSE) {
            $print = FALSE;
          }
        }
      }
      if ($print === FALSE) {
        continue;
      }
      $output[] = '<tr>';
      foreach ($record as $key => $value) {
        if (isset($value) && $value !== "" && in_array($key, $this->options['table_columns'])) {
          $output[] = '<td>' . $value . '</td>';
        }
      }
      $output[] = '</tr>';
    }
    $output[] = '</table></div>';
    return implode("", $output);
  }

  public function buildFilters() {
    $filters = [];
    foreach ($this->records as $record) {
      foreach ($this->records->getHeader() as $header) {
        if (!in_array($header, $this->options['filters'])) {
          continue;
        }
        if (empty($header)) {
          continue;
        }
        if (!isset($filters[$header])) {
          $filters[$header] = [];
        }
        if (strpos($record[$header], ';') === FALSE && !in_array($record[$header], $filters[$header])) {
          $filters[$header][] = trim($record[$header]);
        }
      }
    }
    return $filters;
  }

  public function buildForm() {
    $output = [];
    $output[] = '<form action="//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '" method="POST">';
    foreach ($this->filters as $key => $values) {
      $name = md5($key);
      $output[] = '<select name="' . $name . '">';
      $output[] = '<option value=""> - ' . $key . ' - </option>';
      foreach ($values as $i) {
        $selected = '';
        if (isset($_POST[$name]) && $_POST[$name] === $i) {
          $selected = 'selected';
        }
        $output[] = '<option value="' .  $i . '" ' . $selected . '>' . $i . '</option>';
      }
      $output[] = '</select>';
    }
    $output[] = '<div><input type="submit" value="Filter"><button><a href="//' . $_SERVER['SERVER_NAME'] . '">Reset</a></button></div></form>';
    return implode("", $output);
  }
}
