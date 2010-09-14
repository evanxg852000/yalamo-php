<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * QUERY IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

class Query {
    private $sqlselect;
    private $sqlinsert;
    private $sqldelete;
    private $uqlupdate;
    private $sqlwhere ;
    private $database;

    public function   __construct() {
        $this->database=Database::Instance();
    }

    public function Select($offset=Yalamo::All){
        echo 'all table selected';
    }

}