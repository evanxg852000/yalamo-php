<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * QUERY IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

class Query {

    private $database;

    public function   __construct() {
        $this->database=Database::GetInstance();
    }

    public function SelectAll(){
        echo 'all table selected';
    }

}