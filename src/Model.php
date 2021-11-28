<?php

namespace model;
use \SQLite3;

class Model {

    public string $test;
//     private SQLite3 $db;

    public function __construct() {
//         $this->db = self::getDB();
    }

    static private function getDB() : SQLite3 
    {
        $di = DI::getInstance();
        return $di->get('db');
    }

    private function doGetAll()
    {
        $table = 'Test';
        $q = "select * from :table";
        $stmt = $this->db->prepare($q);
        $stmt->bindValue(":table", $table);
        $stmt->execute();
    }
    
    public function save() 
    {
        $table = strtolower(get_class($this));
        $q = "insert into $table ";

        // get the values to insert
        $vars = get_object_vars($this);
        $q .= "(". implode(", ", array_keys($vars)) .") ";
        $q .= "values (:". implode(", :", array_keys($vars)) .") ";

        // prepare
        $db = self::getDB();
        $stmt = $db->prepare($q);
        foreach ($vars as $key => $value) {
            $stmt->bindValue(':'.$key , $value);
        }
        $stmt->execute();
    }
    
    static public function getAll() 
    {
        $db = self::getDB();
        $table = strtolower(get_called_class());
        $q = "select * from $table";
        $res = $db->query($q);
        $result = [];
        while($row = $res->fetchArray()) {
            $result[] = $row;
        }
        return $result;
    }
    
}
