<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php y(app_config("baseuri"))?>assets/css/style.css"/>
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