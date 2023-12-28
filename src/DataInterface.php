<?php

namespace markfullmer\datainterface;

use League\Csv\Reader;
use League\Csv\Writer;
use League\Csv\Statement;
use League\Csv\ResultSet;
use GuzzleHttp\Client;

/**
 * Application View logic.
 */
class DataInterface {

  public array $options = [
    'file' => '',
    'url' => '',
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
  public function __construct($options) {
    $this->options = $options;
    if (isset($options['file'])) {
      $reader = Reader::createFromPath($options['file'], 'r');
    }
    elseif (isset($options['url'])) {
      $stored_file = md5($options['url']) . '.csv';
      if (file_exists($stored_file) && !isset($_REQUEST['reset'])) {
        $reader = Reader::createFromPath($stored_file, 'r');
        print_r('Retrieving stored file...');
      }
      else {
        $client = new Client();
        $response = $client->get($options['url']);
        if ($response->getStatusCode() !== 200) {
          echo 'CSV could not be loaded.';
          die();
        }
        $body = $response->getBody();
        file_put_contents($stored_file, $body);
        $reader = Reader::createFromString($body);
      }
    }
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
        if (in_array($key, $this->options['table_columns'])) {
          $output[] = '<td>' . nl2br($value) . '</td>';
        }
      }
      $output[] = '</tr>';
    }
    if (!in_array('<tr>', $output)) {
      return 'No records match this criteria.';
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
        if (!empty($record[$header]) && strpos($record[$header], ';') === FALSE && !in_array($record[$header], $filters[$header])) {
          $filters[$header][] = trim($record[$header]);
        }
      }
    }
    foreach ($filters as &$filter_values) {
      asort($filter_values);
    }
    return $filters;
  }

  public function buildForm() {
    $location = '//' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $output = [];
    $output[] = '<form action="' . $location . '" method="POST">';
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
    if (isset($this->options['url'])) {
      $output[] = '<input type="hidden" name="url" value="' . $this->options['url'] . '" />';
    }
    if (isset($this->options['title'])) {
      $output[] = '<input type="hidden" name="title" value="' . $this->options['title'] . '" />';
    }
    if (isset($this->options['filters'])) {
      $output[] = '<input type="hidden" name="filters" value="' . implode(',', $this->options['filters']) . '" />';
    }
    if (isset($this->options['table_columns'])) {
      $output[] = '<input type="hidden" name="table" value="' . implode(',', $this->options['table_columns']) . '" />';
    }
    $output[] = '<div><input type="submit" value="Filter"><button><a href="' . $location . '">Reset</a></button></div></form>';
    return implode("", $output);
  }
}
