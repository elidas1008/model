<?php

namespace model;
use \SQLite3;
use \Exception;

class DI {

    static private DI $instance;
    private array $objects = [];

    protected function __construct(){
        self::$instance = $this;
        $this->creations();
    }

    private function creations() {
        // put all creations here

        // db
        $this->objects['db'] = new SQLite3('database.db');
        $this->objects['db']->enableExceptions(true);

        // test
        $this->objects['test'] = "test ";

    }

    public function get(string $name)
    {
        if (!array_key_exists($name, $this->objects)) throw new Exception("cannot find '$name'");
        return $this->objects[$name];
    }

    static public function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}
