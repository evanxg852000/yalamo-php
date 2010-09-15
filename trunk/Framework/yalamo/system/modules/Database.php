<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * DATABASE IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */
/* Databases Class */
final class Database {
    private static $instance=NULL;
    private $driverObject;
    private function   __construct() {
        switch(DBDRIVER){
		case Yalamo::Mysql:
                   $this->driverObject=new Mysql();
                break;
                case Yalamo::Sqlite:
                   $this->driverObject=new Sqlite();
                break;
                case Yalamo::Pogsql:
                    $this->driverObject=new Pogsql();
		break;
            }
    }
    private function   __clone() {}
    
    public static function Instance(){
        if(!self::$instance){
            self::$instance=new Database();
        }
        return self::$instance;
    }    

    public function Handle(){
        return $this->driverObject;
    }
    public function Connection(){;
        return $this->driverObject->Connection();
    }
    public function Create($name){
      return $this->driverObject->Create($name);
    }
    public function Drop($name){
      return $this->driverObject->Delete($name);
    }
    public function Export($name){
       return $this->driverObject->Export($name);
    }
    public function Databases(){
       return $this->driverObject->Databases();
    }    
}

/* Abstract Base Class for Databases Driver*/
abstract  class DBDriver {
    protected  $connection;
    protected  $result;
    protected final function Onerror($e,$obj){
        $inspector=Inspector::Instance();
        $inspector->Add($e,$obj);
    }

    public abstract function  __construct();
    public abstract function  __destruct();

    public abstract function Connection();
    public abstract function Create($name);
    public abstract function Drop($name);
    public abstract function Export($file);
    public abstract function Databases();

    public abstract function Escape($vars);
    public abstract function Prepare($sql);

    public abstract function Execute($sql);
    public abstract function Select($table,$fields=Yalamo::All,$condition=Yalamo::Void);
    public abstract function Insert($table,$keys,$values,$single=true);
    public abstract function Update($table,$values,$condition=Yalamo::Void);
    public abstract function Delete($table,$condition=Yalamo::Void);

    public abstract function ResultObject();
    public abstract function ResultSet();
    public abstract function ResultArray();
    
    public abstract function Fields();
    public abstract function NumRows();
    public abstract function AffectedRows();

}

