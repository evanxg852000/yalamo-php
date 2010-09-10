<?php
//include the framework
require_once("yalamo/yalamo.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yalamo Test Environement</title>
</head>
<body>
<pre>
<?php


//autoloaded by yalamo
$var=new Cookie();
echo $var->__toString();

//autoloade by php
$v=new Path();
$v->__toString();


$u=new Uri() ;

echo $u->Extract(0);

?>
</pre>
</body>
</html>

http://localhost/Framework/evan/care/var
http://projects.evansofts.com/
