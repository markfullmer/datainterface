# Auto-Parsing Data Search Interface

This is a PHP library that will automatically parse a CSV file and generate a search interface, displaying results in a table.

The library takes a CSV file with a header row as its input, as well as arguments for which column names should be filterable and which columns should display in the table.

### Examples

- [Short stories](https://records.markfullmer.com/examples/stories)
- [LP records](https://records.markfullmer.com/examples/records)

### Specifications & Usage
1. Provide a standard format CSV file with a header row. A simple example is below:

```
Artist,Title,Year
America,America,1971
Eric Andersen,Bout Changes 'n' Things Take 2,1966
```

2. Instantiate the data as a PHP class object. In the example below, the code is being instructed to create a filter for 'Year' and 'Genre' (but not 'Artist') and to display 'Artist', 'Title', and 'Year' in the table:

```php
$app = new DataInterface('records.csv', [
  'title' => 'List of LPs',
  'filters' => ['Year', 'Genre'],
  'table_columns' => ['Artist', 'Title', 'Year'],
]);
```

3. Render the parts of the interface as desired:

```php
echo $app->options['title'];
echo $app->buildForm();
echo $app->buildTable();
```

### Features
- Metadata columns can have multiple values. These should be separated by a semicolon. For example, for an entry that has metadata relating to "Genre" of "Horror" and "Thriller", the CSV file's row for that metadata should be entered as "Horror;Thriller".
