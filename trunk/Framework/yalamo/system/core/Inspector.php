<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * DEBUGGER IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */

/* Error Class */
final class Error {
    const YE000 = "Error YE000: There is not an error";
    const YE001 = "Error YE001: Method or function not implemented";
    
    //arguments
    const YE100 = "Error YE101: Invalid index suplied for array";
    const YE101 = "Error YE101: Invalid argument suplied ";

    //file
    const YE200 = "Error YE200: File not found in the specified path";
    const YE201 = "Error YE201: Directory not found in the specified path";
    const YE202 = "Error YE202: Access denied on specified file";
    const YE203 = "Error YE203: Impossible to upload file";

    //database
    const YE300 = "Error YE300: Unable to connect to the database";
    const YE301 = "Error YE301: SQl query execution error";
    
    //misc
    const YE400 = "Error YE400: Unable to connect to mail server";


    private $num;
    private $string;
    private $subject; //object on which error was raised

    public function  __construct($type=Error::None,$subject=NULL) {
        $parts=explode("|",$type);    
        $this->num=str_replace("|","",$parts[0]);
        $this->string=$parts[1];
        $this->subject=$subject;
    }
    public function  __toString($dump=false) {
        return "Error: ".$this->Num()." , ".$this->String()." With Var= ".$this->Subject($dump);
    }
    public function Num(){
        return $this->num;
    }
    public function String(){
        return $this->string;
    }
    public function Subject($dump=false){
        if($dump){
            var_dump($this->subject);
        }
        return $this->subject;
    }
    
    
}



/* Debugger Class */
final class Inspector {
    private static $instance=null;
    private $errors;

    private function  __construct() {
        $this->errors=array(); 
    }
    private function  __clone() {}
    public static function  Instance(){
        if(!self::$instance){
            self::$instance=new Inspector();
        }
        return self::$instance;
    }

    public function Add($type,$subject=null){
        $error=new Error($type,$subject);
        $this->errors[]=$error;
    }
    public function Error($offset=Yalamo::All){
        if($offset==Yalamo::All){
            return $this->errors;  
        }
        else{
            return $this->errors[$offset];
        }

    }
    public function Investigate($dump=false){
        $log="";
        foreach ($this->errors as $error) {
            $str =$error->__toString().Yalamo::Endline;
            if($dump){
                echo $str;
                $error->Subject(true);
            }
            $log.=$str;
        }
        return $log;
    }
    public function Log(){
        $logfile=YPATH."log.log";
        $f=new File($logfile);
        echo  $logfile;
        $f->Append($this->Investigate());
    }
    
    public static function AddError($type,$subject=null){
         $inspector=Inspector::Instance();
         $inspector->Add($type,$subject);
    }

    
}