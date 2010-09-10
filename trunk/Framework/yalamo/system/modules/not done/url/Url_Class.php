<?php
Final Class Url {

	private $PortionUrl=array("index");  				//segments :     /controller/method/param1/param2/...    $_server['PATH_INFO']
	private $FullUrl;			  						//fullurl:	   http://localhost/index.php/controller/method/param1/param2/....
	private $BaseUrl;			 						//baseurl        http://localhost/index.php
	
	public function __construct()
	{
		if(isset($_SERVER['PATH_INFO']))
		{
			$this->PortionUrl=explode('/',$_SERVER['PATH_INFO']);
		}
		$this->FullUrl=$this->CurrentUrl('full');
		$this->BaseUrl=$this->CurrentUrl('base');
	}

	Public function Extract($num)
	{
		if(array_key_exists($num , $this->PortionUrl))
		{
			return $this->PortionUrl[$num];
		}
		else
		{
			return false;
		}
	}
	
	Public function GetFullUrl()
	{
		return $this->FullUrl;
	}
	
	Public function GetBaseUrl()
	{
		return $this->BaseUrl;
	}
	
	private function CurrentUrl($type) 
	{
		$url = 'http';
		$port='';
		 
		 if (isset($_SERVER["HTTPS"]) and ( $_SERVER["HTTPS"]== "on"))  {	$url .= "s"; }
		 $url .= "://";
		 if ($_SERVER["SERVER_PORT"] !== "80") 
		 {
				$port =':'.$_SERVER["SERVER_PORT"];
		 }
		 
		 switch ($type)
		 {
			case 'base':
				$url .= $_SERVER["SERVER_NAME"].$port.$_SERVER["SCRIPT_NAME"];
			break;
			case 'full':
				$url .= $_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
			break;
		 }
		 return $url;
	}

}

/*
$u=new Url() ;
echo $u->GetBaseUrl();
echo'<br/>'. $u->GetFullUrl();
echo'<br/>'. $u->Extract(3);
*/

?>