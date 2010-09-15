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
            switch(DBDRIVER){
		case Yalamo::Mysql:
                   self::$instance=new Mysql();
                break;
                case Yalamo::Sqlite:
                   self::$instance=new Sqlite();
                break;
                case Yalamo::Pogsql:
                   self::$instance=new Pogsql();

		break;
            }
        }
        return self::$instance;
    }    
   
    public function Create($name){
      return self::$instance->Create($name);
    }
    public function Drop($name){
      return self::$instance->Delete($name);
    }
    public function Export($name){
       return self::$instance->Export($name);
    }
    public function Databases(){
       return self::$instance->Databases();
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