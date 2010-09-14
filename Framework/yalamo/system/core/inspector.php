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
    
    const YE100 = "YE101|Invalid Argument/File Supllied Error";
    const YE101 = "YE102|Invali argument/ file supllied";
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
    
}



/* Debugger Class */
final class Inspector {
    private static $instance=NULL;
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

    public function Add($type,$subject=NULL){
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
        $str="";
        foreach ($this->errors as $error) {
            $str =$str." ".$error->__toString()." \n";
        }
        if($dump){
            echo $str;
        }
        return $str;
    }

}


