<?php if ( ! defined('YPATH')) exit('Access Denied !');
/**
 * Yalamo framework
 *
 * A fast,light, and constraint-free Php framework.
 *
 * @package		Yalamo
 * @author		Evance Soumaoro
 * @copyright           Copyright (c) 2009 - 2011, Evansofts.
 * @license		http://projects.evansofts.com/yalamof/license.html
 * @link		http://evansofts.com
 * @version		Version 0.1
 * @filesource          Userconfig.php
 */

$DATABASECONFIG=array(
"test"=>array(
	"DRIVER"=>"MYSQL",
	"HOST"=>"localhost",
	"USER"=>"root",
	"PASSWORD"=>""
	),
"slite"=>array(
	"DRIVER"=>"SQLITE" ,
	"HOST"=>"C:\wamp\apps\sqlitemanager1.2.4\data\slitedb.sqlite3",
	"USER"=>"",
	"PASSWORD"=>""
	),
"pog"=>array(
	"DRIVER"=>"POSTGRESQL",
	"HOST"=>"localhost",
	"USER"=>"postgres",
	"PASSWORD"=>"root",
        "PORT"=>5432
	),
"carnic"=>array(
	"DRIVER"=>"MYSQL",
	"HOST"=>"localhost",
	"USER"=>"root",
	"PASSWORD"=>""
	),
"DBNAME"=>array(
	"DRIVER"=>"POSTGRESQL",
	"HOST"=>"server.com",
	"USER"=>"admin",
	"PASSWORD"=>"yourpass",
        "PORT"=>5432
	)
);
