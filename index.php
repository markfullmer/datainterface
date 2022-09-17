<?php

require 'vendor/autoload.php';
require 'head.html';

?>
<div class="container">
  <div class="row">
    <h1>Auto-Parsing Data Search Interface</h1>
    <p>This is a PHP library that will automatically parse a CSV file and generate a search interface, displaying results in a table.</p>
    <p>The library takes a CSV file with a header row as its input, as well as arguments for which column names should be filterable and which columns should display in the table.</p>
    <h3>Examples</h3>
    <ul>
      <li>
        <a href="/examples/stories">Short stories</a>
      </li>
      <li>
        <a href="/examples/records">LP records</a>
      </li>
    </ul>
    <h3>Specifications & Usage</h3>
    1. Provide a standard format CSV file with a header row. A simple example is below:
    <pre><code>Artist,Title,Year
America,America,1971
Eric Andersen,Bout Changes 'n' Things Take 2,1966</code></pre>
    2. Instantiate the data as a PHP class object. In the example below, the code is being instructed to create a filter for 'Year' and 'Genre' (but not 'Artist') and to display 'Artist', 'Title', and 'Year' in the table:
    <pre><code>&lt;?php
$app = new DataInterface('records.csv', [
  'title' => 'List of LPs',
  'filters' => ['Year', 'Genre'],
  'table_columns' => ['Artist', 'Title', 'Year'],
]);</code></pre>
    3. Render the parts of the interface as desired:
    <pre><code>&lt;?php
echo $app->options['title'];
echo $app->buildForm();
echo $app->buildTable();
</code></pre>
  </div>
</div>
