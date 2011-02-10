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
 * REQUIRE PHP EXT/ php_mysql
 * The class that implements the driver for Mysql database engine
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
        $handle=@mysql_connect($this->configuration["HOST"],$this->configuration["USER"],$this->configuration["PASSWORD"]);
        if($handle){
            $this->connection=$handle;
            $currentdb=@mysql_select_db($this->dbname);
            if(!$currentdb){
                $this->PCollect(Error::YE301,  $this);
            }
        }
        else {
			$this->connection=false;
			$this->PCollect(Error::YE301, $this );
        }
        $this->ResetActiveRecord();
    }
    public function  __destruct(){
        if(is_resource($this->connection)){
            if(! @mysql_close($this->connection)){
                $this->PCollect(Error::YE301,  mysql_error($this->connection));
            }
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
                $this->PCollect(Error::YE301,mysql_error($this->connection));
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
        return @mysql_insert_id($this->connection);
    }
    public function NumRows(){
        return @mysql_num_rows($this->result);
    }
    public function AffectedRows(){
        return @mysql_affected_rows($this->connection);
    }

    //Result fetching
    public function ResultSet(){
        $result=array();
	while($row=@mysql_fetch_assoc($this->result) ){
            $result[]=(array) $row;
	}
        return new ResultSet($result);
    }

     //security
    public function Escape($input){
        if(is_array($input)){
            foreach ($input as $key => $value) {
                $output[$key]=@mysql_real_escape_string($value, $this->connection);
            }
            return $output;
        }
        return @mysql_real_escape_string($input, $this->connection);     
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
