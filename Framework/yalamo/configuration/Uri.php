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

$URICONFIG["BASE"]="http://localhost/Framework/";

/*
 * "/{custome}/{page}/{controller}/{action}/{param}/"
 * "/{custome}/{controller}/{action}/{param}/"
 */
$URICONFIG["SCHEME"]="/{controller}/{action}/{param}/";

$URICONFIG["MODE"]="Mvc";

$URICONFIG["DEFAULTCONTROLLER"]="Welcome";

$URICONFIG["DEFAULTPAGE"]="Classic";

$URICONFIG["MAP"]=array(
    "http://evansofts.com/index/news/"=>"http://evansofts.com/news/",
    "http://localhost/Framework/evance/test/goog/"=>"http://google.com"
);


