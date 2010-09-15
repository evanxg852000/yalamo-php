<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * QUERY IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */
/* Query Class */
class Query {
    private $driverObject;

    public function __construct() {
        $this->driverObject=Database::Instance()->Handle();
    }
    public function Execute($sql){
        $this->driverObject->Execute($sql);
    }
    public function Select($table,$fields=Yalamo::All,$condition=Yalamo::Void){
        $this->driverObject->Select($table,$fields=Yalamo::All,$condition=Yalamo::Void);
    }
    public function Insert($table,$keys,$values,$single=true){
        $this->driverObject->Insert($table,$keys,$values,$single=true);
    }
    public function Update($table,$values,$condition=Yalamo::Void){
        $this->driverObject->Update($table,$values,$condition=Yalamo::Void);
    }
    public function Delete($table,$condition=Yalamo::Void){
        $this->driverObject->Delete($table,$condition=Yalamo::Void);
    }

    public function ResultObject(){
        $this->driverObject->ResultObject();
    }
    public function ResultSet(){
        $this->driverObject->ResultSet();
    }
    public function ResultArray(){
        $this->driverObject->ResultArray();
    }

    public function Fields(){
        $this->driverObject->Fields();
    }
    public function NumRows(){
        $this->driverObject->NumRows();
    }
    public function AffectedRows(){
        $this->driverObject->AffectedRows();
    }
}

