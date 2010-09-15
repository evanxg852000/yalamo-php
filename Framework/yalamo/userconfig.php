<?php if ( ! defined('YPATH')) exit('Access Denied !');
/*
 * USER CONFIGURATION
 *
 *
 *
 * @author Evance Soumaoro
 */


/* Array Extensions */
$Extensions[] = array();

/* Autoload Arrays */
$AutoModules    = array('cookie');
$AutoHelpers    = array('regex','string');
$AutoExtensions = array('paypal','Javascript');

/* Application and Custom Configuration  */

$AppConfig[]=array(
    'Errors'=> false,

    'AdminEmail'=> 'evanxg852000@yahoo.fr',
    'Title'=>'Yalamo dev Environment',
    'Copyright'=> 'Evansofts 2010'
	//... add new like  'key' : value	
);	



/* Database Configuration */
define("DBDRIVER", "MYSQL"); 		//change this value [MYSQL,POSTGRESQL,SQLITE]
define("DBSERVER", "localhost");                   //change this value                  //change this value
define("DBNAME", "test");                         //C:/data/mydata.db for sqlite     //change this value
define("DBUSER", "root"); 							//change this value
define("DBPASSWORD", ""); 							//change this value


/* Mvc Configuration */
define("SITEURL", "http://localhost/Framework/");
define("MVCPATH", YPATH."mvc/");                       //mvc path
define("DEFAULTCONTROLLER", "Welcome");							
