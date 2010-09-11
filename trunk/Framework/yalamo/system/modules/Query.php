<?php

class Query {

    private $database;

    public function   __construct() {
        $this->database=Database::GetInstance();
        echo 'this is a query';
    }

    public function SelectAll(){
        echo 'all table selected';
    }

}