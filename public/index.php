<?php
main::start("example.csv");
/* Description: Class to initialize main
 * Parameters: filename, variable used to read the CSV file content.
 * Result: read records from CSV file and display in html table.
 */
class main  {
    static public function start($filename) {
        $records = csv::getRecords($filename);
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