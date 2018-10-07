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
                //Create records Array
            }
            $count++;
        }
        fclose($file);
        return $records;
    }
}
?>