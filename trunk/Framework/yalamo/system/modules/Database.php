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
 * @filesource          Database.php
 */

/*
 * DATABASE IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

//------------------------------------------------------------------------------
/**
 * Databases Class
 *
 * The class that contains the implementation of manipulating and handling a database
 * during the application life cycle for performence reason, it has been made singleton
 * if you whish to manipulate many connections you should use the databse driver instead
 *
 */
final class Database extends Singleton {
    private static $instance=null;
    private $driver_object;

    private function   __construct($isdefault=true) {  
        if($isdefault){
            $databases=cf("DATABASE");
            $name=key($databases);
            $configuration=$databases[$name];
             switch ($databases[$name]['DRIVER']) {
                    case Yalamo::Mysql:
                        $this->driver_object=new Mysql($name,$configuration);
                    break;
                    case Yalamo::Sqlite:
                        $this->driver_object=new Sqlite($name,$configuration);
                    break;
                    case Yalamo::Pogsql:
                        $this->driver_object=new Pogsql($name,$configuration);
                    break;
              }
        }
    }
    
    public static function Instance(){
        if(!self::$instance){
            self::$instance=new Database();
        }
        return self::$instance;
    }    
    public static function Parallel($name){
        $databases=cf("DATABASE");
        $instance=new Database(false);
        $configuration=$databases[$name];
        switch ($databases[$name]['DRIVER']) {
            case Yalamo::Mysql:
                   $instance->driver_object=new Mysql($name, $configuration);
                break;
                case Yalamo::Sqlite:
                    $instance->driver_object=new Sqlite($name,$configuration);
                break;
                case Yalamo::Pogsql:
                     $instance->driver_object=new Pogsql($name,$configuration);
		break;
        }
        return $instance;
    }

    public function Name(){
       return $this->driver_object->DBName();
    }
    public function Configuration(){
        return $this->driver_bject->Configuration();
    }
    public function Handle(){
        return $this->driver_object;
    }
    public function Connection(){;
        return $this->driver_object->Connection();
    }
    public function Query(){
        return new Query($this->driver_object);
    }

    public function Create($name=Yalamo::Void){
        if($name==Yalamo::Void){
            $name=$this->Name();
        }
        return $this->driver_object->DBCreate($name);
    }
    public function Drop($name=Yalamo::Void){
        if($name==Yalamo::Void){
            $name=$this->Name();
        }
        return $this->driver_object->DBDrop($name);
    }
    public function Tables($name=Yalamo::Void){
        if($name==Yalamo::Void){
            $name=$this->Name();
        }
        return $this->driver_object->DBTables($name);
    }
    public function Export($file,$name=Yalamo::Void){
        if($name==Yalamo::Void){
            $name=$this->Name();
        }
        return $this->driver_object->DBExport($file,$name);
    }

}

//------------------------------------------------------------------------------
/**
 * DBDriver Class
 *
 * The abstract Base Class for Databases Driver. any supported database engine should extends this class
 */
abstract  class DBDriver extends Object {
    protected  $dbname;
    protected  $configuration;
    protected  $connection;
    protected  $result;
    protected  $last_inserted;
    protected  $num_rows;
    protected  $afected_rows;
    protected  $active_record;

    protected function ResetActiveRecord(){
        $this->active_record=array();
        $this->active_record['insert']="";
        $this->active_record["select"]="";
        $this->active_record["update"]="";
        $this->active_record["delete"]="";

        $this->active_record["on"]="";

        $this->active_record["where"]="";
        $this->active_record["where_counter"]=0;

        $this->active_record["limit"]="";

        $this->active_record["order"]="";
        $this->active_record["order_counter"]=0;


    }

    public function Configuration(){
        return $this->configuration;
    }
    public function Connection(){
        return $this->connection;
    }
    public function DBName(){
        return $this->dbname;
    }

    public abstract function  __construct($dbname,$configuration);
    public abstract function  __destruct();

    //Database opeartion area
    public abstract function DBCreate($name);
    public abstract function DBDrop($name);
    public abstract function DBTables($name);
    public abstract function DBExport($file,$name);
    public abstract function Execute($sql);

    //Active recorde area
    public abstract function On($table);
    public abstract function Where($condition,$logic);
    public abstract function Limit($s,$count);
    public abstract function Order($param,$direction);

    public abstract function Insert($keys,$values,$is_multipe);
    public abstract function Select($fields);
    public abstract function Update($values);
    public abstract function Delete();

    //Meta data
    public abstract function LastId();
    public abstract function NumRows();
    public abstract function AffectedRows();

    //Result fetching
    public abstract function ResultSet();
    
     //security
    public abstract function Escape($input);
    public abstract function Prepare($sql,$data);

}

//------------------------------------------------------------------------------
/**
 * DBDriver Class
 *
 * The abstract Base Class for Databases Driver. any supported database engine should extends this class
 */
class ResultSet extends Object {
    private $data;

    function  __construct($array) {
        $this->data=$array;
    }

    public function AsArray(){
        return $this->data;
    }
    public function AsObject(){
        $result=array();
        foreach ($this->data as $key => $value) {
            $result[$key]=(Object)$value;
        }
        return $result;
    }
    public function AsAssoc($prefix){
        $result=array();
        foreach ($this->data as $key => $value) {
            $result[$prefix."_".$key]=$value;
        }
        return $result;
    }
    
}