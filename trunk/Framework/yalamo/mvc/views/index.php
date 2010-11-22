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
 padding: 1px 3px 1px 3px;
 margin: 2px;
 color: forestgreen;
 -moz-border-radius:3px;
 -webkit-border-radius:3px;
 border-radius:3px;
}

#col-one {
    width: 890px;
    float: left;
}

#col-two{
   width: 276px;  
   float: right; 
   
   margin: 0px 5px ;


}
#links{
   border: solid 1px #003399;
   background-color: #f9f9f9;
   border: 2px solid #D0D0D0;
   min-height: 250px;
   -moz-border-radius:3px;
   -webkit-border-radius:3px;
   border-radius:3px;
}

</style>
<title><?php echo $title ?></title>
<?php loadjs(Jslib::Jquery, "1.4.2")  ?>
</head>
<body>
    <h1>Hi Sparky !</h1>
    <p>
        Welcome to yalamo framework, the fastest and constraint free web application framework!<br/>
        Customise this page from here  <code>yalamo/mvc/views/index.php</code>
    </p>
    <div id="col-one">
      <h1>Taste It !</h1>
 <code>yalamo/mvc/controllers/Welcome.php</code>
<pre>
&lt;?php
class Welcome extends Controller {

    public function Index(){
        $this->Model=$this->Load->Model('Users');
        $this->Model->Create('Evance Soumaoro');
        $this->Variables['message']="New User Created ";
        
        $this->Load->View('index', $this->Variables);
    }

}
</pre>
<code>yalamo/mvc/models/Users.php</code>
<pre>
&lt;?php
class Users extends Model {
   
    public function Create($name){
        $u=new User();
        $u->id=null;
        $u->name=$name;
        $item=$u->Rows()->Create($u);
        parent::Insert($item);
    }
}

//user table
class User extends Table{
    public $id;
    public $name;
}
</pre>
      <h1>Benchmark </h1>
        <?php
            Profiler::CheckPoint("View");
            $i=  Inspector::Instance()->Investigate(true);
            echo Profiler::Profile();
        ?>

      <h1>Thanks ! </h1>
    <p>
        Thank you for downloading yf, I hope you will enjoy using it like I did when developing it.
    </p>
    </div>
    <div id="col-two">
        <h1>Get Started ! </h1>
        <div id="links">
            <ul>
                <li><a href="http://evansofts.com">Home</a></li>
                <li><a href="#">Quick Start</a></li>
                <li><a href="#">User Guide</a></li>
                <li><a href="#">API Doc</a></li>
                <li><a href="#">Forum</a></li>
            </ul>
        </div>

    </div>
    

    
</body>
</html>