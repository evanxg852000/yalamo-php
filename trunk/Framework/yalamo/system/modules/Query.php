<?php if ( ! defined('YPATH')) exit('Access Denied !');
/**
 * Yalamo framework
 *
 * A fast,light, and constraint-free Php framework.
 *
 * @package		Yalamo
 * @author		Evance Soumaoro
 * @copyright           Copyright (c) 2009 - 2011, Evansofts.
 * @license		http://projects.evansofts.com/yalamof/license.html
 * @link		http://evansofts.com
 * @version		Version 0.1
 * @filesource          Query.php
 */

/*
 * QUERY IMPLEMENTATION
 *
 * Contains database query functionalities through abstraction of sql statement
 */

//------------------------------------------------------------------------------
/**
 * Query Class
 *
 * Define methods for querying a database
 */
class Query extends Object{
    private $dbhandle;

    public function __construct(& $dbhandle) {
        $this->dbhandle=& $dbhandle;
    }

    public function Execute($sql){
        $this->dbhandle->Execute($sql);
        return $this;
    }

    //Active record area
    public function On($table){
        $this->dbhandle->On($table);
        return $this;
    }
    public function Where($condition,$logic="AND"){
        $this->dbhandle->Where($condition, $logic);
        return $this;
    }
    public function Limit($sart,$count){
        $this->dbhandle->Limit($sart, $count);
         return $this;
    }
    public function Order($field,$direction="ASC"){
        $this->dbhandle->Order($field, $direction);
         return $this;
    }

    public function Insert($keys,$values,$is_multipe=false){
        $this->dbhandle->Insert($keys, $values, $is_multipe);
        return $this;
    }
    public function Select($fields=Yalamo::All){
       $this->dbhandle->Select($fields);
       return $this;
    }
    public function Update($values){
        $this->dbhandle->Update($values);
        return $this;
    }
    public function Delete(){
        $this->dbhandle->Delete();
        return $this;
    }

    //Meta data
    public function LastId(){
        return $this->dbhandle->LastId();
    }
    public function NumRows(){
        return $this->dbhandle->NumRows();
    }
    public function AffectedRows(){
        return $this->dbhandle->AffectedRows();
    }

    //Result fetching
    public function ResultSet(){
        return $this->dbhandle->ResultSet();
    }

     //security
    public function Escape($input) {
        return $this->dbhandle->Escape($input);
    }
    public function Prepare($sql,$data) {
        $this->dbhandle->Prepare($sql,$data);
        return $this;
    }

}
