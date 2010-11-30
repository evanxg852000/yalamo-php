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
 * @filesource          Mysql.php
 */

/*
 * MYSQL DRIVER IMPLEMENTATION
 *
 *  The class that implements the driver for Mysql database engine
 */

//------------------------------------------------------------------------------
/**
 * Mysql Class
 *
 * Implements abstract methods from the DBDriver class for mysql engine
 * 
 */
final class Mysql extends DBDriver {

    public function  __construct($dbname,$configuration) {
        $this->dbname=$dbname;
        $this->configuration=& $configuration;
        $this->statement=Yalamo::Void;
        $handle=@mysql_connect($this->configuration["HOST"],$this->configuration["USER"],$this->configuration["PASSWORD"]);
        if($handle){
            $this->connection=$handle;
            $currentdb=@mysql_select_db($this->dbname);
            if(!$currentdb){
                $this->PCollect(Error::YE301,  $this);
            }
        }
        else {
            $this->PCollect(Error::YE301,mysql_error() );
            $this->connection=false;
        }
        
    }
    public function  __destruct(){
       if(! @mysql_close($this->connection)){
           $this->PCollect(Error::YE301,mysql_error());
       }
    }
    

    //Database opeartion area
    public function DBCreate($name){
        return $this->Execute("CREATE DATABASE $name ;");
    }
    public function DBDrop($name){
        return $this->Execute("DROP DATABASE $name ;");
    }
    public function DBTables($name){
        return $this->Execute("SHOW TABLES IN $name ;");
    }
    public function DBExport($file,$name){
         $this->Collect(Error::YE001);
    }
    public function Execute($sql){
        if($this->connection){
            $this->result= @mysql_query($sql, $this->connection);
            if(!$this->result){
                $this->Collect(mysql_error());
                return false;
            }
        }
        return $this;
    }

    //Active recorde area
    public function On($table){;
        $this->statement.="{left} ".$table." {right} ";
        return $this;
    }
    public function Where($param,$logic="AND"){}
    public function Limit($s,$count){}
    public function Order($param,$direction){}
    public function Join($table,$condition){}
    public function Insert(){}
    public function Select(){}
    public function Update($values){}
    public function Delete(){}

    //Meta data
    public function LastId(){
        return @mysql_insert_id($this->connection);
    }
    public function NumRows(){
        return mysql_num_rows($this->result);
    }
    public function AffectedRows(){
        return @mysql_affected_rows($this->connection);
    }

    //Result fetching
    public function ResultSet(){
        $result=array();
	while($row=@mysql_fetch_assoc($this->result) ){
            $array = (array) $row;
            $result[]=$array;
	}
        return new ResultSet($result);;
    }

     //security
    public function Escape($vars){}
    public function Prepare($sql,$data){}

    

}


class Mysqllegcy {
    public function Escape($vars) {
        if(is_array($vars)){
            foreach ($vars as $key => $val) {
                $vars[$key]=@mysql_real_escape_string($val, $this->connection);
            }
        }
        else{
            $vars=@mysql_real_escape_string($vars, $this->connection);
        }
        return $vars;
    }
    public function Prepare($sql,$data) {
      if(is_array($data)){
          foreach ($data as $key => $val) {
              $val=  $this->Escape($val);
              $sql=str_replace("{".$key."}", $val, $sql);
          }
        return $sql;
      }
      else {
          $this->Collect(Error::YE101);
          return false;
      }
    }

    public function Execute($sql) {
        if($this->connection){
            $this->result= @mysql_query($sql, $this->connection);
            if(!$this->result){
                $this->PCollect(Error::YE301, mysql_error());
                return false;
            }
        }
        return $this->result;
    }
    public function Select($table,$fields=Yalamo::All,$condition=Yalamo::Void){
        if(is_array($fields)){
            $fields=implode(" , ", $fields);
        }
        $sql="SELECT $fields FROM $table ".$condition." ;" ;
        $this->Execute($sql);
    }
    public function Insert($table,$keys,$values,$single=true){
        if((!is_array($keys) || (!is_array($values)))){
            $this->PCollect(Error::YE101,array($keys,$values) );
            return false;
        }
        $keys=implode(" , ",$keys);
        if($single){
            foreach ($values as  $val) {
                if(is_string($val)){ $val="'$val'";}
                if(is_null($val)){ $val="NULL"; }
                $str[]=$val;
            }
            $values="( ".implode(",", $str)." ) ";
        }
        else{
            $temparray=array();
            for ($i=0; $i<count($values);$i++) {
                $str=array();
                foreach ($values[$i] as  $val) {
                if(is_string($val)){
                    $val="'$val'";
                }
                 $str[]=$val;
                }
                $temparray[]="( ".implode(",", $str)." ) ";
            }

            $values=implode(",", $temparray);
        }
        $sql="INSERT INTO $table ( $keys ) VALUES  $values ;";
        $this->Execute($sql);
        return $this->AffectedRows();
    }
    public function Update($table,$values,$condition=Yalamo::Void,$astring=true){
        if(is_array($values)){
            foreach ($values as $key => $val) {
                if(!is_string($key)){ $this->PCollect(Error::YE101, $values);  return false;}
                if((is_string($val)) && ($astring==true)){ $val="'$val'"; }
                $str[]=$key."=".$val;
            }
            $values=implode(" , ", $str);
        }
        else{
            $this->PCollect(Error::YE101, $values);
            return false;
        }
        $sql="UPDATE $table SET $values ".$condition." ;";
        $this->Execute($sql);
        return $this->AffectedRows();
    }
    public function Delete($table,$condition=Yalamo::Void){
        $sql="DELETE FROM $table ".$condition." ;";
        $this->Execute($sql);
        return $this->AffectedRows();
    }

    public function ResultObject() {
        $resultobjects=array();
        while($obj= @mysql_fetch_object($this->result)){
                $resultobjects[]=$obj;
        }
        return $resultobjects;
    }
    public function ResultSet() {
        $result=array();
	while($row=@mysql_fetch_assoc($this->result) ){
            $array = (array) $row;
            $result[]=$array;
	}
        return $result;
    }
    public function ResultArray() {
        $result=array();
	while($row =mysql_fetch_row($this->result)){
            $result[]=$row;
	}
        return $result;
    }

    public function Fields(){
        $result=array();
	while($row =mysql_fetch_field($this->result)){
            $fieldObject=new stdClass();
            $fieldObject->Name =$row->name;
            $fieldObject->Table =$row->table;
            $fieldObject->Default =$row->def;
            $fieldObject->MaxLength =$row->max_length;
            $fieldObject->NotNull =$row->not_null;
            $fieldObject->PrimaryKey =$row->primary_key;
            $result[]=$fieldObject;
	}
        return $result;
    }
    public function NumRows(){
        return @mysql_num_rows($this->result);
    }
    public function AffectedRows(){
        if($this->connection){
            return @mysql_affected_rows($this->connection);
        }
         else {
            return 0;
        }
    }

}