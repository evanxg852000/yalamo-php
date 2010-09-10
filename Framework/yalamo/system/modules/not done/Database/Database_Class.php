<?php
Final Class  Database  {
	Private static $handle = NULL;
	
	Private function __construct()
	{
		# Nothing just to prevent from instanciating new one
	}
	
	Private function __clone()
	{
		# Nothing just to prevent from cloning this object
	}
	
	# To Get an instance of this object
	Public static function GetInstance()
	{
		if (!self::$handle)
			{
				self::$handle=new Database();
			}
		return self::$handle;
	}
	
	# To escape a single string data
	Public function Escape($string)
	{
		try
		{
			$pdo = DatabaseConnexion::GetInstance();
			return $pdo->quote($string);
		}
		catch (PDOException $e)
		{
		
		}
	}
	
	# To escape an array string data wich is intented to be used in Request or Insert method
	Public function EscapeAll($data)
	{	
		try
		{
			$pdo = DatabaseConnexion::GetInstance();
			$result=array();
			foreach($data as $key=>$val)
			{
				$result[$key]=$pdo->quote($val); 
			}
			return $result;
		}
		catch (PDOException $e)
		{
		
		}
	}
	
	# Execute an sql request like insert,update,Delete by using the Sql syntaxe'
	Public function Request($sql) 
	{
		try
		{
			$pdo = DatabaseConnexion::GetInstance();
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			return true;
		}
		catch (PDOException $e)
		{
		
		}
	}
	
	# Insert directly into a table without using any Sql syntaxe
	# $table='mytable' is the table name
	# $data=array('name' => $name, 'email' => $email, 'url' => $url);
	# $data is escaped inside so no need to escape
	Public function Insert($table,$data) 
	{	
		# Preparation fo the $sql statement
		$sql="INSERT INTO $table ";
		$db = Database::GetInstance(); 
		$data=$db->EscapeAll($data);
		$sub1=" ( ";
		$sub2=" VALUES ( " ;
		$keys=array_keys($data);
		
		for($i=0;$i<count($data);$i++)
		{
			if($i!==count($data)-1)
			{
				$sub1 .=$keys[$i]." , ";
				$sub2 .=$data["$keys[$i]"]." , " ; 
			}
			else
			{
				$sub1 .= $keys[$i]." )";
				$sub2 .= $data["$keys[$i]"]." )";
			}
		}
		# Execution
		$sql.=$sub1.$sub2 ;
		$bool=$db->Request($sql);
		return $bool;
	}
	
	# Delete directly into a table without using any Sql syntaxe
	# $table='mytable' is the table name
	# $where is the condition clause (optional)
	# Note: any input in the where must be escaped manually using the databas utilis YalEscape() function
	Public function Delete($table,$where="") 
	{
		# Preparation fo the $sql statement
		$sql="DELETE FROM $table ";
		$db = Database::GetInstance();
		if($where!=="")
		{
			$sql .=" WHERE ".$where;
		}
		echo $sql;
		# Execution
		$bool=$db->Request($sql);
		return $bool;
	}
	
	# Update directly into a table without using any Sql syntaxe
	# $table='mytable' is the table name
	# $set is the new values : "Name='evance'"
	# $where is the condition clause (optional) :'num=3'
	# Note: any input in the where must be escaped manually using the databas utilis YalEscape() function
	Public function Update($table,$set,$where="") 
	{
		# Preparation fo the $sql statement
		$sql="UPDATE $table ";
		$db = Database::GetInstance();
		$sql .=" SET ".$set;
		if($where!=="")
		{
			$sql .=" WHERE ".$where;
		}
		# Execution
		$db = Database::GetInstance(); 
		$bool=$db->Request($sql);
		return $bool;
	}
	
	# Execute an sql select request  by using the Sql syntaxe;
	# return an array of object
	Public function Select($sql)
	{
		$result=array();
		try
		{
			$pdo = DatabaseConnexion::GetInstance();
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			while($obj = $stmt->fetch(PDO::FETCH_OBJ))
			{
				$result[] = $obj;
			}
			return $result ;
		}
		catch (PDOException $e)
		{
		
		}
	}
	
	# Execute an sql select request  by using the Sql syntaxe;
	# return an associative array 
	Public function SelecttAssoc($sql)
	{
		$result=array();
		$db = Database::GetInstance(); 
		$var=$db->Select($sql);
		foreach($var as $obj)
		{
			$array = (array) $obj;
			$result[]=$array;
		}
		return $result;
	}



	# Select the content of a table without any sql syntaxe
	# Return an array object 
	Public function Get($table)      
	{
		# Preparation fo the $sql statement
		$db = Database::GetInstance();
		$sql="SELECT* FROM $table ";
		# Execution
		$result=$db->Select($sql);
		return $result;
	}
	
	# Select the content of a table without any sql syntaxe
	# Return an associativ array 
	Public function GetAssoc($table)      
	{
		# Preparation fo the $sql statement
		$db = Database::GetInstance(); 
		$sql="SELECT* FROM $table ";
		# Execution
		$result=$db->SelecttAssoc($sql);
		return $result;
	}
	
	# Select the content of a table 
	# $where is the condition clause (optional)
	# Return an  array object
	Public function  GetWhere($table,$where="") 
	{
		# Preparation fo the $sql statement
		$db = Database::GetInstance(); 
		$sql="SELECT* FROM $table ";
		if($where!=="")
		{
			$sql .="  WHERE $where ";
		}
		# Execution
		$result=$db->Select($sql);
		return $result;
	}
	
	# Select the content of a table 
	# $where is the condition clause
	# Return an associativ array 
	Public function  GetWhereAssoc($table,$where="") 
	{	
		# Preparation fo the $sql statement
		$db = Database::GetInstance(); 
		$sql="SELECT* FROM $table ";
		if($where!=="")
		{
			$sql .="  WHERE $where ";
		}
		# Execution
		$result=$db->SelecttAssoc($sql);
		return $result;
	}
}

?>