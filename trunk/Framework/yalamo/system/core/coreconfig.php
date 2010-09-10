<?php  if ( ! defined('YPATH')) exit('Access Denied !');
//CORE CONFIGURATION

define('YModule','Yalamo');
define('YTYPE','PHP Framework');
define('YVERSION','0.2');
define('YLICENCE','LGPL');
define('YAUTHOR','Evance Soumaoro');

define('YCOREFILE'  ,  YPATH.'system'.DS.'core'.DS.'core.php' );
define('YMODELFILE' ,  YPATH.'system'.DS.'core'.DS.'model.php');
define('YURIFILE'   ,  YPATH.'system'.DS.'core'.DS.'uri.php');


define('YMODULEDIR'    , YPATH.'system'.DS.'modules'.DS);
define('YHELPERSDIR'   , YPATH.'system'.DS.'helpers'.DS);
define('YEXTENTIONDIR' , YPATH.'extention'.DS);


/* Array Modules */
$YFiles['modules'] = array(
'Cookie',
'Database',
'Environment',
'File',
'Image',
'Model',
'Path',
'Session',
'Zip'
    //...
);



/* Array Helpers */
$YFiles['helper'] = array(
'String',
'Regex',
'Uri'
//...
);



/* Array Autoload */
$YAutoLoad = array (
	'modules'=>$AutoModules,
	'helpers'=>$AutoHelpers,
	'extensions'=>$AutoExtensions
);

