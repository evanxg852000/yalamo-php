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
            $db_name=key($databases);
            $configuration=$databases[$db_name];
             switch ($databases[$db_name]['DRIVER']) {
                    case Yalamo::Mysql:
                        $this->driver_bject=new Mysql($db_name,$configuration);
                    break;
                    case Yalamo::Sqlite:
                        $this->driver_object=new Sqlite($db_name,$configuration);
                    break;
                    case Yalamo::Pogsql:
                        $this->driver_object=new Pogsql($db_name,$configuration);
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
       return $this->driver_bject->DBName();
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
        return new Query($this);
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
        return $this->driver_object->Tables($this->name);
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
    protected  $statement;
    protected  $result;
    protected  $last_inserted;
    protected  $num_rows;
    protected  $afected_rows;

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
    public abstract function Where($param,$logic="AND");
    public abstract function Limit($s,$count);
    public abstract function Order($param,$direction);
    public abstract function Join($table,$condition);
    public abstract function Insert();
    public abstract function Select();
    public abstract function Update($values);
    public abstract function Delete();

    //Meta data
    public abstract function LastId();
    public abstract function NumRows();
    public abstract function AffectedRows();

    //Result fetching
    public abstract function ResultSet();
    
     //security
    public abstract function Escape($vars);
    public abstract function Prepare($sql,$data);


}



//    public abstract function Select($table,$fields=Yalamo::All,$condition=Yalamo::Void);
//    public abstract function Insert($table,$keys,$values,$single=true);
//    public abstract function Update($table,$values,$condition=Yalamo::Void,$astring=true);
//    public abstract function Delete($table,$condition=Yalamo::Void);

//------------------------------------------------------------------------------
/**
 * DBDriver Class
 *
 * The abstract Base Class for Databases Driver. any supported database engine should extends this class
 */
class ResultSet extends Object {
    private $result;

    function  __construct($result_array) {
        $this->result=$result_array;
    }

    public function Object(){

    }
    public function Assoc(){

    }
    public function Rarray(){

    }
}