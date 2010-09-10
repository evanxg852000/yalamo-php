<?php
//include the framework
require_once("yalamohp/yalamo.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yalamo Test Environement</title>

<?php
YalUsing('YAL.Base');
YalImport("YAL.PHP.PAC.Database") ;


?>

</head>
<body onload="m()">

<?php


$db = Database::GetInstance(); 
 $var=$db-> SelecttAssoc('select* from tutilisateur');

foreach($var as $val)
{
	echo $val['Mail'];
}

?>

</body>
</html>
