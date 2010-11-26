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
final class Database extends Object {
    private static $instance=NULL;
    private $driverObject;
    private $name;
    private $configuration;

    private function   __construct($isdefault=true) {
        global $DATABASES;
        if($isdefault){
            $this->name=key($DATABASES);
            $this->configuration=$DATABASES[$this->name];
             switch ($DATABASES[$this->name]['DRIVER']) {
                    case Yalamo::Mysql:
                        $this->driverObject=new Mysql($this->configuration);
                    break;
                    case Yalamo::Sqlite:
                        $this->driverObject=new Sqlite($this->configuration);
                    break;
                    case Yalamo::Pogsql:
                        $this->driverObject=new Pogsql($this->configuration);
                    break;
              }
        }
    }
    private function   __clone() {}
    
    public static function Instance(){
        if(!self::$instance){
            self::$instance=new Database();
        }
        return self::$instance;
    }    
    public static function Parallel($dbname){
        global $DATABASES;
        $Instance=new Database(false);
        $Instance->name=$dbname;
        $Instance->configuration=$DATABASES[$Instance->name];
        switch ($Instance->configuration['DRIVER']) {
            case Yalamo::Mysql:
                   $Instance->driverObject=new Mysql($Instance->configuration);
                break;
                case Yalamo::Sqlite:
                    $Instance->driverObject=new Sqlite($Instance->configuration);
                break;
                case Yalamo::Pogsql:
                     $Instance->driverObject=new Pogsql($Instance->configuration);
		break;
        }
        return $Instance;
    }

    public function Name(){
       return $this->name;
    }
    public function Configuration(){
        return $this->configuration;
    }
    public function Handle(){
        return $this->driverObject;
    }
    public function Connection(){;
        return $this->driverObject->Connection();
    }
    public function Query(){
        return new Query($this);
    }

    public function Create(){
      return $this->driverObject->DBCreate($this->name);
    }
    public function Drop(){
      return $this->driverObject->DBDrop($this->name);
    }
    public function Tables(){
        return $this->driverObject->Tables($this->name);
    }
    public function Export(){
       return $this->driverObject->DBExport($this->name);
    }
    
}

//------------------------------------------------------------------------------
/**
 * DBDriver Class
 *
 * The abstract Base Class for Databases Driver. any supported database engine should extends this class
 */
abstract  class DBDriver extends ICollectable {
    protected  $connection;
    protected  $result;
    
    /**
     * The methode that makes a derived class collectable by the inspector
     * and provide for that reason an easy way to raise error on that object
     *
     * @param Error::Enum $errortype
     */
    protected function Collect($errortype) {
        $inspector=Inspector::Instance();
        $inspector->Add($errortype,  $this);
    }
    
    /**
     * The P means Personalised which helps passed a specific object rather that the
     * Top level object
     *
     * @param Error::Enum $errortype
     * @param mixed $subject
     */
    protected function PCollect($errortype,$subject){
        $inspector=Inspector::Instance();
        $inspector->Add($errortype,  $subject);
    }
    
    public abstract function  __construct($configuration);
    public abstract function  __destruct();

    public abstract function Connection();
    public abstract function Create($name);
    public abstract function Drop($name);
    public abstract function Export($file);
    public abstract function Databases();

    public abstract function Escape($vars);
    public abstract function Prepare($sql,$data);

    public abstract function Execute($sql);
    public abstract function Select($table,$fields=Yalamo::All,$condition=Yalamo::Void);
    public abstract function Insert($table,$keys,$values,$single=true);
    public abstract function Update($table,$values,$condition=Yalamo::Void,$astring=true);
    public abstract function Delete($table,$condition=Yalamo::Void);

    public abstract function ResultObject();
    public abstract function ResultSet();
    public abstract function ResultArray();
    
    public abstract function Fields();
    public abstract function NumRows();
    public abstract function AffectedRows();

//Database opeartion area
    public abstract function DBCreate($name);
    public abstract function DBDrop($name);
    public abstract function DBTables();
    public abstract function DBExport();

//Active recorde area
    public abstract function On($table){

    }
    public abstract function Where($param,$logic="AND"){

    }
    public abstract function Limit($s,$count){

    }
    public abstract function Order($param,$direction){

    }
    public abstract function Join($table,$condition){

    }
    public abstract function Insert(){

    }
    public abstract function Select(){

    }
    public abstract function Update($values){

    }
    public abstract  function Delete(){

    }

}

