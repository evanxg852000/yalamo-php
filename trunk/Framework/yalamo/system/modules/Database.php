<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * DATABASE IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */
final class Database {
    private static $instance=NULL;
    private function   __construct() {}
    private function   __clone() {}
    
    public static function Instance(){
        if(!self::$instance){
            self::$instance=new Database();
            switch(DBDRIVER){
		case Yalamo::Mysql:
                   self::$instance=new Mysql();
                break;
                case Yalamo::Sqlite:
                   // self::$instance=Sqlite::Instance();
                break;
                case Yalamo::Pogsql:
                   // self::$instance=Pogsql::Instance();
		break;
            }
        }
        return self::$instance;
    }    
    public function Create($name){
    }
    public function Delete($name){
    }
    public function Export($name){
    }

    
}

/* Abstract Base Class for Databases */
abstract  class DBDriver {
    protected  $connection;
    protected  $result;
    protected function Onerror($e,$obj){
        $inspector=Inspector::Instance();
        $inspector->Add($e,$obj);
    }

    public abstract function Connection();
    public abstract function Create($name);
    public abstract function Drop($name);
    public abstract function Export($file);
    public abstract function Databases();

    public abstract function Escape($vars);
    public abstract function Prepare($sql);

    public abstract function Execute($sql);
    public abstract function Select($table,$fields=Yalamo::All,$where=Yalamo::Void,$config=null);
    public abstract function Insert($table,$keys,$values,$single=true);
    public abstract function Update($table,$values,$where=Yalamo::Void,$config=null);
    public abstract function Delete($table,$where=Yalamo::Void,$config=null);

    public abstract function ResultObject();
    public abstract function ResultSet();
    public abstract function ResultArray();
    
    public abstract function Fields();
    public abstract function NumRows();
    public abstract function AffectedRows();

}




/* MYSQL class */
final class Mysql extends DBDriver{
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
        $this->Execute($sql);
    }
    public function Drop($name){
         $sql="DROP DATABASE $name ;";
         $this->Execute($sql);
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
    public function Select($table,$fields=Yalamo::All,$where=Yalamo::Void,$config=null){
        if(is_array($fields)){
            $fields=implode(" , ", $fields);
        }
        if(is_array($where)){
            $where=implode("=", $where);
        }
        $sql="SELECT $fields FROM $table ";
        $sql.= (!empty($where)) ? "WHERE $where " : Yalamo::Space ;
        $sql.= $config ;
       
        echo $sql;
        //$this->Execute($sql);
        //return $this->ResultSet();
    }
    public function Insert($table,$keys,$values,$single=true){
        if((!is_array($keys) || (!is_array($values)))){
            $this->Onerror(Error::YE100, array($keys,$values));
        }
        $keys=implode(" , ",$keys);
        if($single){
            $values=implode(",", $values);
        }
        else{
            for ($i=0; $i<count($values)-1;$i++) {
               $tempstr .= "( ".implode(Yalamo::Space, $values[$i])." ) ," ;
            }
            $tempstr .= "( ".implode(Yalamo::Space, $values[count($values)-1])." ) ";
            $values=$tempstr;
        }
        $sql="INSERT INTO $table "."( $keys ) VALUES  $values ; ";
        $this->Execute($sql);
        return $this->ResultSet();
    }
    public function Update($table,$values,$where=Yalamo::Void,$config=null){
        if(is_array($values)){
            foreach ($values as $key => $val) {
                $str[]=$key."=".$val;
            }
            $values=implode(" , ", $str);
        }
        $sql="UPDATE $table SET $values  ";
        $sql.= (!empty($where)) ? "WHERE ".implode(Yalamo::Space, $where) : Yalamo::Space ;
        $sql.= $config ;
        $this->Execute($sql);
        return $this->AffectedRows();
    }
    public function Delete($table,$where=Yalamo::Void,$config=null){
        $sql="DELETE FROM $table ";
        $sql.= (!empty($where)) ? "WHERE ".implode(Yalamo::Space, $where) : Yalamo::Space ;
        $sql.= $config ;
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





















/* SQLITE class */
final class Sqlite{
    private static $connection=NULL;
    private $databases;
    private function  __construct() {
        $this->databases=array();
    }
    private function  __clone() {}

    public static function Instance(){
        if(!self::$connection){
             $dsn = "sqlite2:\"".DBNAME."\" ";
             try{
                self::$connection = new PDO($dsn);
                self::$connection-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             }
             catch (PDOException $e){
                $inspector=Inspector::Instance();
                $inspector->Add(Error::YE105, $e);
             }
        }
        return self::$connection;
    }

    public function Create($name){
        return true;
    }
    public function Delete($name){
        if ( (!file_exists($name)) || (! unlink($name))){
            $inspector=Inspector::Instance();
            $inspector->Add(Error::YE101, $name);
            return false;
	}
	return true;
    }
    public function Export($name){
    }
    public function Databases(){
        return $this->databases ;
    }

    public function Escape($statement){}
}

/* POSTGRESQL class */
final class Pogsql{
    private static $connection=NULL;
    private function  __construct() {}
    private function  __clone() {}

    public static function Instance(){
        if(!self::$connection){
            $dsn="pgsql:host=".DBSERVER." port=5432 dbname=".DBNAME." user=".DBUSER." password=".DBPASSWORD."";
            try{
                self::$handle = new PDO($dsn);
                self::$handle-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e){
                $inspector=Inspector::Instance();
                $inspector->Add(Error::YE105, $e);
            }
        }
        return self::$connection;
    }
    public function Create($name){
    }
    public function Delete($name){
    }
    public function Export($name){
    }

}