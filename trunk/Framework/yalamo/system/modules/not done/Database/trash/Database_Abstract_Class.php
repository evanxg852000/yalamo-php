<?php
Abstract Class ADatabase Implements IDatabase{
	
	Protected  $sql;
	Protected $handle; //for sqlite
	
	Public function __construct($sql) { 
	 $this->sql=$sql;
	}
	
	Abstract Protected function Connect();
	
	Public function SelectToXml()
	{
		$result="";
		$array=$this->Select();
		if($array!==false)
		{
			$result.='<?xml version="1.0"?>'."\n" ;
			$result.='<records>'."\n" ;
			for($i=0;$i<count($array);$i++)
			{
				$result.='<record>'."\n" ;
				foreach($array[$i] as $key=>$val)
				{
					$result.='<'.$key.'>'.$val.'<'.$key.'>'."\n" ;
				}	
				$result.='</record>'."\n" ;
			}
			$result.='</records>'."\n" ;
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	Public function SelectToCvs()
	{
		$result="";
		$array=$this->Select();
		if($array!==false)
		{
			$t=array_keys($array[0]) ;
			foreach($t as $val)
			{
				$result.=$val."," ;
			}
			
			foreach($array as $subarray)
			{
				foreach($subarray as $val)
				{
					$result.=$val."," ;
				}	
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
}
?>