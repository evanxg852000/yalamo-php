<?php

class Query {

    private $database;

    public function   __construct() {
        $this->database=Database::GetInstance();
    }

    public function SelectAll(){
        echo 'all table selected';
    }

}