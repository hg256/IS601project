<!DOCTYPE html>
<html lang="en">
<head>
    <title>CSV to Table Conversion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<center>
<h1>Dynamically Creating a Table from CSV File</h1>
</center>
<?php
main::start("example.csv");
/* Description: Class to initialize main
 * Parameters: filename, variable used to read the CSV file content.
 * Result: read records from CSV file and display in html table.
 */
class main  {
    static public function start($filename) {
        $records = csv::getRecords($filename);
        $table = html::generateTable($records);
        $displaytable = displaytable::display($table);
    }
}

/* Description: Class to initialize records and construct a Bootstrap table
 * Parameters: $records, Array used to obtain the CSV file content's key - value pair.
 * Result: traverse through $records array.
 */
class html {
    public static function generateTable($records)
    {
        $tablestruct = tablefactory::addDivContainer();
        $tablestruct .= tablefactory::addTable();
        $count = 1;
        $tablestruct .= tablefactory::addTableHeaders();
        $tablestruct .= tablefactory::addrow();
        foreach ($records[0] as $fields => $values) {
            $tablestruct .= tablefactory::addTableHeaderTag($fields);
        }
        $tablestruct .= tablefactory::endrow();
        $tablestruct .= tablefactory::endTableHeaders();
        $tablestruct .= tablefactory::addTableBody();
        foreach ($records as $arrays) {
            if ($count > 0) {
                $tablestruct .= tablefactory::addrow();
                foreach ($arrays as $fields => $values) {
                    $tablestruct .= tablefactory::addcolumn($values);
                }
                $tablestruct .= tablefactory::endrow();
            }
            $count++;
        }
        $tablestruct .= tablefactory::endTableBody();
        $tablestruct .= tablefactory::endTable();
        $tablestruct .= tablefactory::endDivContainer();
        return $tablestruct;
    }

}

/* Description: Class to pass values to individual table component tags
 * Parameters: $fields, variable used to form header content
 * Parameters: $values, variable used to bind data inside a column tag
 * Result: This class serves as a utility/helper to generate Bootstrap table
 *         from start to end with the help of component tags as individual methods
 *         returned for each row.
 */
class tablefactory{

    public static function addDivContainer($attribute = "<div class=\"container\">"){
        return $attribute;
    }
    public static function endDivContainer($attribute = "</div>"){
        return $attribute;
    }
    public static function addTable($attribute = "<table class=\"table table-striped\">"){
        return $attribute;
    }
    public static function endTable($attribute = "</table>"){
        return $attribute;
    }
    public static function addTableHeaders($attribute = "<thead>"){
        return $attribute;
    }
    public static function endTableHeaders($attribute = "</thead>"){
        return $attribute;
    }
    public static function addTableBody($attribute = "<tbody>"){
        return $attribute;
    }
    public static function endTableBody($attribute = "</tbody>"){
        return $attribute;
    }
    public static function addTableHeaderTag($fields){
        $attribute = "<th>" .$fields ."</th>";
        return $attribute;
    }
    public static function addrow($attribute = "<tr>"){
        return $attribute;
    }

    public static function endrow($attribute = "</tr>"){
        return $attribute;
    }

    public static function addcolumn($values){
        $attribute = "<td>" . $values . "</td>";
        return $attribute;
    }


}

/* Description: Class to validate if variable has value to print or not
 * Parameters: $tablestruct, variable used to obtain the CSV file contents in Bootstrap Table format.
 * Result: Print the table if variable is present else print a message.
 */

class displaytable
{
    public static function display($tablestruct)
    {
        if($tablestruct != null){
            echo $tablestruct;
        }
        else{
            echo "No data available to display currently! Please validate your CSV File";
        }

    }
}

/* Description: Class to initialize records as key - value pair from CSV file
 * Parameters: $filename, variable used to obtain the CSV file contents.
 * Result: return an array with CSV contents as key-value pair.
 */
class csv {
    static public function getRecords($filename) {
        $file = fopen($filename,"r");
        $fieldNames = array();
        $count = 0;
        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}

/* Description: Class to initialize a record value using a contructor to define the variables passed by reference
 * Parameters: NA, Constructor is defined.
 * Result: Calls the constructor on initialization to assign fieldNames and
 *         Values as key-value pair for each row of $Records Array.
 */
class record {
    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);
        foreach ($record as $property => $value) {
            $this->{$property} = $value;
        }
    }

}

/* Description: Class to initialize records Array when called from another class
 * Parameters: $fieldNames, variable used to separate the CSV's headers from its values.
 *             Takes first line as Header values and passes array $record back to class CSV with its properties.
 * Parameters: $values, variable to assign CSV content for each row of data and return
 *             the array $record back to class CSV with its properties.
 * Result: Returns the Array $record by arranging the header and content values in key-value pair.
 */

class recordFactory {
    public static function create(Array $fieldNames = null, Array $values = null) {
        $record = new record($fieldNames, $values);
        return $record;
    }
}
?>