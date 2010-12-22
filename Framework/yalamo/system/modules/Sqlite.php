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
 * @filesource          Sqlite.php
 */

/*
 * SQLITE DRIVER IMPLEMENTATION
 * REQUIRE PHP EXT/ php_sqlit3
 * The class that implements the driver for Sqlite database engine
 */

//------------------------------------------------------------------------------
/**
 * Sqlite Class
 *
 * Implements abstract methods from the DBDriver class for Sqlite engine
 */
final class Sqlite extends DBDriver{

    public function  __construct($dbname,$configuration) {
        $this->dbname=$dbname;
        $this->configuration=& $configuration;
        $handle= new SQLite3($this->configuration["HOST"],SQLITE3_OPEN_READWRITE);
        if($handle){
            $this->connection=$handle;
        }
        else{
            $this->connection=false;
            $this->PCollect(Error::YE300,$handle->lastErrorMsg());
        }
        $this->ResetActiveRecord();
    }
    public function  __destruct(){
       if(is_object($this->connection)){
          if(!$this->connection->close()){
              $this->PCollect(Error::YE301,$this->connection->lastErrorMsg());
          }
       }
    }

    //Database opeartion area
    public function DBCreate($name){
        return new SQLite3($name,SQLITE3_OPEN_CREATE);
    }
    public function DBDrop($name){
        return unlink($name);
    }
    public function DBTables($name){
        return $this->Execute("SELECT name FROM sqlite_master WHERE type='table';");
    }
    public function DBExport($file,$name){
       $sql= "SELECT sql FROM sqlite_master WHERE type='table';";
       $tables=$this->Execute($sql)->ResultSet()->AsObject();
       $content="--dumping database {$name} \n";
       foreach($tables as $val ){
         $content .= $val->sql." ; \n";
       }
       $f=new File($file.".sql");
       return $f->Create($content);
    }
    public function Execute($sql){
        if($this->connection){
            $this->result=$this->connection->query($sql);
            if(!$this->result){
                $this->PCollect(Error::YE301,$this->connection->lastErrorMsg());
                return false;
            }
        }
        return $this;
    }

    //Active recorde area
    public function On($table){;
        $this->active_record["on"]=$table;
        return $this;
    }
    public function Where($condition,$logic){
        if( $this->active_record["where_counter"]<=0){
            $sql ="WHERE ".$condition;
        }  else {
            $sql = " ".$logic." ".$condition;
        }
        $this->active_record["where_counter"]++;
        $this->active_record['where'] .=$sql;
        return $this;
    }
    public function Limit($sart,$count){
        $sql="LIMIT $sart , $count";

        $this->active_record["limit"]=$sql;
        return $this;
    }
    public function Order($field,$direction){
        $Stmt="ORDER BY {fields}  {$direction}";
        if( $this->active_record["order_counter"]<=0){
            $sql ="ORDER BY  ".$field." ".$direction ;
        }  else {
            $sql =", ".$field." ".$direction ;
        }
        $this->active_record["order_counter"]++;
        $this->active_record['order'] .=$sql;
        return $this;
    }

    public function Insert($keys,$values,$is_multipe){
        if((!is_array($keys) || (!is_array($values)))){
            $this->PCollect(Error::YE101,array($keys,$values) );
            return false;
        }
        if(!$is_multipe){
            foreach ($values as  $key=>$val) {
                $temp[$key]=  $this->get_sql_data($val);
            }
            $values="( ".implode(",", $temp)." ) ";
        }
        else{
            foreach ($values as  $records) {
                foreach ($records as $key=>$val){
                    $tempval[$key]=  $this->get_sql_data($val);
                }
                $temp[]="( ".implode(",", $tempval)." ) ";
            }
            $values=implode(",", $temp);
        }
        $sql="INSERT INTO {table} ( {keys} ) VALUES {values};";
        $sql=str_replace("{table}", $this->active_record["on"], $sql);
        $sql=str_replace("{keys}", implode(" , ",$keys), $sql);
        $sql=str_replace("{values}",$values, $sql);
        $this->ResetActiveRecord();
        return $this->Execute($sql);
    }
    public function Select($fields){
        if(is_array($fields)){
            $fields=implode(" , ", $fields);
        }
        $sql="SELECT {fields} From {table} {condition} {limit};";
        $sql=str_replace("{fields}", $fields, $sql);
        $sql=str_replace("{table}", $this->active_record["on"], $sql);
        $sql=str_replace("{condition}", $this->active_record["where"], $sql);
        $sql=str_replace("{limit}",  $this->active_record["limit"], $sql);
        $this->ResetActiveRecord();
        return $this->Execute($sql);
    }
    public function Update($values){
        if(is_array($values)){
            $values=implode(" , ", $values);
        }
        $sql="UPDATE {table} SET {values} {condition} {limit};";
        $sql=str_replace("{table}", $this->active_record["on"], $sql);
        $sql=str_replace("{values}",  $values, $sql);
        $sql=str_replace("{condition}", $this->active_record["where"], $sql);
        $sql=str_replace("{limit}",  $this->active_record["limit"], $sql);
        $this->ResetActiveRecord();
        return $this->Execute($sql);
    }
    public function Delete(){
        $sql="DELETE FROM {table} {condition} {limit};";
        $sql=str_replace("{table}", $this->active_record["on"], $sql);
        $sql=str_replace("{condition}", $this->active_record["where"], $sql);
        $sql=str_replace("{limit}",  $this->active_record["limit"], $sql);
        $this->ResetActiveRecord();
        return $this->Execute($sql);
    }

    //Meta data
    public function LastId(){
        return $this->connection->lastInsertRowID();
    }
    public function NumRows(){
        $counter=0;
	while($row=$this->result->fetchArray()){
            $counter++;
	}
        return $counter;
    }
    public function AffectedRows(){
        return $this->connection->changes();
    }

    //Result fetching
    public function ResultSet(){
        $result=array();
	while($row=$this->result->fetchArray(SQLITE3_ASSOC)){
            $result[]=(array) $row;
	}
        return new ResultSet($result);
    }

     //security
    public function Escape($input){
        if(is_array($input)){
            foreach ($input as $key => $value) {
                $output[$key]=$this->connection->escapeString($value);
            }
            return $output;
        }
        return $this->connection->escapeString($value);
    }
    public function Prepare($sql,$data){
      if(is_array($data)){
          foreach ($data as $key => $val) {
              $sql=str_replace("{".$key."}",$this->Escape($val), $sql);
          }
        return $this->Execute($sql);
      }
      $this->Collect(Error::YE101);
      return $this;
    }

    private function get_sql_data($data){
        if(is_null($data)){return "NULL";}
        if(is_string($data)){ return "'$data'";}
        return $data;
    } 
}