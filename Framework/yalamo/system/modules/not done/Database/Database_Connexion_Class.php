<?php
Final Class DatabaseConnexion {

	Private static $handle = NULL;

	Private function __construct() //notthing just to prevent from calling
	{
		
	}
	
	Private function __clone() //nothing juste to forbid from clonning this singleton object
	{
		
	}

	Public static function GetInstance() {

		if (!self::$handle)
			{
				switch(YALAMO_DB_DRIVER)
				{
					case 'POSTGRE':
						$dsn='pgsql:host='.YALAMO_DB_SERVER.' port=5432 dbname='.YALAMO_DB_NAME.' user='.YALAMO_DB_USER.' password='.YALAMO_DB_PASSWORD.'';
						try{
							self::$handle = new PDO($dsn);
							self::$handle-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						}
						catch (PDOException $e)
						{
						
						}
					break;
					case 'MYSQL':
						$dsn = 'mysql:host='.YALAMO_DB_SERVER.';dbname='.YALAMO_DB_NAME.';';
						try{
							self::$handle = new PDO($dsn,YALAMO_DB_USER,YALAMO_DB_PASSWORD);
							self::$handle-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						}
						catch (PDOException $e)
						{
						
						}
					break;
					case 'SQLITE':
						$dsn = 'sqlite2:"'.YALAMO_DB_PATH.'"';
						try
						{
							self::$handle = new PDO($dsn);
							self::$handle-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						}
						catch (PDOException $e)
						{
						
						}
					break;
				}
			}
		return self::$handle;
	}
	
}

?>