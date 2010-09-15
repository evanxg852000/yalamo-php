<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * SQLITE DRIVER IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

/* Sqlite class */
final class Sqlite extends DBDriver{
    public function  __construct() {
        $this->result=NULL;
        $handle=@mysql_connect(DBSERVER,DBUSER,DBPASSWORD);
        $currentdb=mysql_select_db(DBNAME);
        if($handle && $currentdb){
            $this->connection=$handle;
        }
        else {
            $this->Onerror(Error::YE105,mysql_error());
            $this->connection=false;
        }
        return $this->connection;
    }

    public function Connection() {
        return $this->connection;
    }
    public function Create($name){
        $sql="CREATE DATABASE $name ;";
        return $this->Execute($sql);
    }
    public function Drop($name){
         $sql="DROP DATABASE $name ;";
         return $this->Execute($sql);
    }
    public function Export($file){
        $this->Onerror(Error::YE001,$name);
    }
    public function Databases() {
        $dbs=array();
        if($this->connection){
            $list=mysql_list_dbs($this->connection);

            while($db= mysql_fetch_row($list)){
                $dbs[]=$db[0];
            }
        }
        return $dbs;
    }

    public function Escape($vars) {
        if(is_array($vars)){
            for($i=0 ; $i<count($vars); $i++) {
                $vars[$i]=@mysql_real_escape_string($vars[$i], $this->connection);
            }
        }
        else{
            $vars=@mysql_real_escape_string($vars, $this->connection);
        }
        return $vars;
    }
    public function Prepare($sql) {
      $this->Onerror(Error::YE001,$name);
    }

    public function Execute($sql) {
        if($this->connection){
            $this->result= @mysql_query($sql, $this->connection);
            if(!$this->result){
                $this->Onerror(Error::YE106,mysql_error());
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
        return $this->ResultSet();
    }
    public function Insert($table,$keys,$values,$single=true){
        if((!is_array($keys) || (!is_array($values)))){
            $this->Onerror(Error::YE100, array($keys,$values));
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
    public function Update($table,$values,$condition=Yalamo::Void){
        if(is_array($values)){
            foreach ($values as $key => $val) {
                if(!is_string($key)){ $this->Onerror(Error::YE100, $values);  return false;}
                if(is_string($val)){ $val="'$val'";}
                $str[]=$key."=".$val;
            }
            $values=implode(" , ", $str);
        }
        else{
            $this->Onerror(Error::YE100, $values);
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
        while($obj=  mysql_fetch_object($this->result)){
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
