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
    //List of identified errors type
    const None  = "YE000|There is not an error";
    const YE001 = "YE001|Not Implemented Error";
    
    const YE100 = "YE101|Invalid Argument/File Suplied Error";
    const YE101 = "YE102|Invali argument/ file suplied";
    //...
    const YE105 = "YE105|Database connection Error";
    const YE106 = "YE106|Database Query Error";
    //...

    private $num;
    private $string;
    private $subject; //object on which error was raised

    //type=Error::YE102
    public function  __construct($type=Error::None,$subject=NULL) {
        $parts=explode("|",$type);    
        $this->num=str_replace("|","",$parts[0]);
        $this->string=$parts[1];
        $this->subject=$subject;
    }
    public function  __toString() {
        return "Error: ".$this->Num()." , ".$this->String()." With Var= ".$this->Subject(true);
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
    public static function LogInspector(){
        $inspector =Inspector::Instance();
        $logfile=YPATH."InspectorLog";
        //TODO finish log inspection after file
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
            echo $str;
            if($dump){
                var_dump($error->Subject());
            }
            $log.=$str;
        }
        return $log;
    }

    public static function AddError($type,$subject=null){
         $inspector=Inspector::Instance();
         $inspector->Add($type,$subject);
    }

}


