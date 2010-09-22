<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * COOKIE IMPLEMENTATION
 *
 *
 *
 * @author Evance Soumaoro
 */
class Cookie{
    private $lifetime;
    private $path;

    public function  __construct($liftime=31536000,$path=Yalamo::Void) {
       if(is_numeric($liftime)){
           $this->lifetime=$liftime;
       }
       if(is_string($liftime)){
           $unite=substr($liftime, -1, 1);
           $val=(int)substr($liftime,0, -1);
           switch ($unite) {
               case "Y":
                        $this->lifetime=$val*365*24*3600;
                    break;
               case "D":
                        $this->lifetime=$val*24*3600;
                    break;
                case "H":
                        $this->lifetime=$val*3600;
                    break;
                case "M":
                        $this->lifetime=$val*60;
                    break;
            }
       }
       $this->path=$path;
    }
    
    public function  __toString() {
        return "Object of Type: Cookie";
    }

    public function Set($key, $value){
       if($this->path===Yalamo::Void){
           return setcookie($key, $value,  time()+$this->lifetime);
       }
        else{
           return setcookie($key, $value,  time()+$this->lifetime, $this->path);
       }
    }
    public function Create($cookies){
        if(is_array($cookies)){
            foreach($cookies as $key=>$value){
            $this->Set($key, $value);
            }
            return true;
        }
        Inspector::AddError(Error::YE101, $cookies);
        return false;
    }
    public function Delete($keys){
        if(is_array($keys)){
            foreach($keys as $key){
                $this->Set($key,  Yalamo::Void);
            }
            return true;
        }
        else {
           return $this->Set($keys,  Yalamo::Void);
        }
    }
    public function Content($key){
        if (array_key_exists($key, $_COOKIE)){
           return $_COOKIE[$key];
	}
         return false;
    }

    public static function Clear($keys=Yalamo::All){
        if($keys===Yalamo::All){
            foreach ($_COOKIE as $key=>$val){
                @setcookie($key, Yalamo::Void);
            }
            return true;
        }
        if(is_array($keys)){
            foreach($keys as $key){
                $this->Set($key,  Yalamo::Void);
            }
            return true;
        }
        else {
           return $this->Set($keys,  Yalamo::Void);
        }
    }
    
}
