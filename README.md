# Auto-Parsing Data Search Interface

This [PHP](https://php.net) library will automatically parse a [CSV](https://en.wikipedia.org/wiki/Comma-separated_values) file and generate a search interface, displaying results in a table.

### Examples

- [Corpus of short stories openings](https://records.markfullmer.com/examples/stories)
- [List of LP records](https://records.markfullmer.com/examples/records)

The library takes a CSV file with a header row as its input, as well as arguments for which column names should be filterable and which columns should display in the table. The library provides two main methods for rendered output: the form, and the table.

### Specifications & Usage
1. Create a standard-format CSV file with a header row. A simple example is below:

```
Artist,Title,Year,Genre
America,America,1971,Rock
Eric Andersen,Bout Changes 'n' Things Take 2,1966,Rock
```

2. Add this PHP library to your project in the standard way:

```
composer require markfullmer/datainterface
```

3. Instantiate the data as a PHP class object. In the example below, the code is being instructed to create a filter for 'Year' and 'Genre' (but not 'Artist') and to display 'Artist', 'Title', and 'Year' in the table:

```php
use markfullmer\datainterface\DataInterface;

$app = new DataInterface([
  'file' => 'records.csv',
  'title' => 'List of LPs',
  'filters' => ['Year', 'Genre'],
  'table_columns' => ['Artist', 'Title', 'Year'],
]);
```

The library also supports reading CSV data over HTTP (including public, [published Google Sheets as CSV](https://support.google.com/a/users/answer/9308870?hl=en)). To use this approach, provide a `url` parameter:

```php
$app = new DataInterface([
  'file' => 'https://example.com/records.csv',
  'title' => 'List of LPs',
  'filters' => ['Year', 'Genre'],
  'table_columns' => ['Artist', 'Title', 'Year'],
]);
```

If reading data over HTTP, the library stores the URL in the filesystem for performance reasons. To refresh the request, add `?reset` to the website URL.

4. Render the parts of the interface as desired:

```php
echo $app->options['title'];
echo $app->buildForm();
echo $app->buildTable();
```

### Features
- Metadata columns can have multiple values. These should be separated by a semicolon. For example, for an entry that has metadata relating to "Genre" of "Horror" and "Thriller", the CSV file's row for that metadata should be entered as "Horror;Thriller".

### Possible enhancements
- Support other data structure inputs, such as JSON
- Keyword search (taking column names as parameters for targets)
- Cache parsing of data for filters for performance
