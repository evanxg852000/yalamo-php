<?php  if ( ! defined('YPATH')) exit('Access Denied !');
//CORE CONFIGURATION

define('YModule','Yalamo');
define('YTYPE','PHP Framework');
define('YVERSION','0.2');
define('YLICENCE','LGPL');
define('YAUTHOR','Evance Soumaoro');

define('YCOREFILE'  ,  YPATH.'system'.DS.'core'.DS.'core'.EXT );
define('YMODELFILE' ,  YPATH.'system'.DS.'core'.DS.'model'.EXT);
define('YURIFILE'   ,  YPATH.'system'.DS.'core'.DS.'uri'.EXT);
define("YMVCFILE"   ,  YPATH.'system'.DS.'core'.DS.'mvc'.EXT);


define('YMODULEDIR'    , YPATH.'system'.DS.'modules'.DS);
define('YHELPERSDIR'   , YPATH.'system'.DS.'helpers'.DS);
define('YEXTENTIONDIR' , YPATH.'extensions'.DS);


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

