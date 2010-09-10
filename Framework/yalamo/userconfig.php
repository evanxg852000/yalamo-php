<?php if ( ! defined('YPATH')) exit('Access Denied !');
//USER CONFIGURATION

/* Array Extensions */
$Extensions[] = array();

/* Autoload Arrays */
$AutoModules    = array('cookie','database');
$AutoHelpers    = array('regex','string');
$AutoExtensions = array('paypal');

/* Application and Custom Configuration  */

$AppConfig[]=array(
    'Errors'=> false,
    'Url'=>'http://localhost/Framework',
    'AdminEmail'=> 'evanxg852000@yahoo.fr',
    'Title'=>'Yalamo dev Environment',
    'Copyright'=> 'Evansofts 2010'
	
	//... add new like  'key' : value
	
);	



/* Database Configuration */
define("DBDRIVER", "MYSQL"); 							//change this value [POSTGRE,SQLITE]
define("DBSERVER", "localhost");                   //change this value
define("DBPATH", "C:/data/mydata.db");                   //change this value
define("DBNAME", "test");                   //change this value
define("DBUSER", "root"); 							//change this value
define("DBPASSWORD", ""); 							//change this value


/* Mvc Configuration */
define("MVCPATH", "mvc");                       //mvc path		
define("DEFAULTCONTROLLER", "Welcome");							
