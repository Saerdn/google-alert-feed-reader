<?php
/**
 * Author: Andreas Geisler
 * Date: 06.06.16
 *
 * Description:
 * Abstract, generic class for working with the database
 */
namespace DB;

abstract class DB
{
    protected $table = '';
    protected $dbc = null;

    public function __construct()
    {
        try {
            $this->dbc = new \PDO("mysql:dbname=". DATABASE .";host=". HOST .";", DBLOGIN, DBPASS);
        } catch(\PDOException $e) {
            // TODO: Logging
            print_r($e);
        }
    }

    /**
     * Write data into database
     * @params array
     * @return mixed
     */
    public function write( $columnAndValues ) {
        // Create partial string for column in sql query
        $columnsString = array_keys($columnAndValues);
        $columnsString = implode(",", $columnsString);

        // Create the binding parameters with a colon (e.g. ":parameter")
        $columnAsBindingAndValue = [];
        foreach( $columnAndValues as $column => $value ) {
            $columnAsBindingString = ":{$column}";
            $columnAsBindingAndValue[$columnAsBindingString] = $value;
        }

        // Create partial string for column in sql query
        $columnsStringAsBinding = array_keys($columnAsBindingAndValue);
        $columnsStringAsBinding = implode(",", $columnsStringAsBinding);

        // Set SQL query
        $stmt = $this->dbc->prepare("INSERT IGNORE INTO ". $this->table. " (". $columnsString .") 
                                     VALUES (". $columnsStringAsBinding .") ");

        // Bind the query parameters
        foreach($columnAsBindingAndValue as $columnBinding => $value) {
            // $stmt->bindParam doesnt work in a loop as it requires a reference.
            // See: http://stackoverflow.com/questions/4174524/binding-params-for-pdo-statement-inside-a-loop
            $stmt->bindValue($columnBinding, $value, \PDO::PARAM_STR);
        }
        $stmt->execute();
    }
}