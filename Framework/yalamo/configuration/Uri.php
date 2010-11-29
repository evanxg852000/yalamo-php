<?php if ( ! defined('YPATH')) exit('Access Denied !');

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


