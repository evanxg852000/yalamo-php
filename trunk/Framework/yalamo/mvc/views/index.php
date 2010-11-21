<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Verdana, Sans-serif;
 font-size: 15px;
 color: #4F5155;
}
p {
    line-height: 17px;   
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 2px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 10px 0 10px 0;
 padding: 5px 0 3px 0;
}

pre {
 font-size: 14px;
 font-family: consolas ;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 -moz-border-radius:3px;
 -webkit-border-radius:3px;
 border-radius:3px;
 color: forestgreen;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 5px 12px 5px;
}
code {
 font-size: 14px;
 font-family: consolas ;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 -moz-border-radius:3px;
 -webkit-border-radius:3px;
 border-radius:3px;
 padding: 1px 3px 1px 3px;
 margin: 2px;
 color: forestgreen;

}

</style>
<title><?php echo $title ?></title>
<?php loadjs(Jslib::Jquery, "1.4.2")  ?>
</head>
<body>

    <h1>Hi Sparky !</h1>
    <p>
        Welcome to yalamo framework, the fastest and constraint free web application framework!<br/>
        Get started with the <a href="welcome/hello">API documentation</a>.Customise this page from here 
        <code>yalamo/mvc/views/index.php</code>
    </p>
    <h1>Taste It !</h1>
    <pre>
          $this->Load->View('index');
    </pre>

    <h1>Benchmark </h1>      
    <?php
        Profiler::CheckPoint("View");
        $i=  Inspector::Instance()->Investigate(true);
        echo Profiler::Profile();
    ?>
</body>
</html>