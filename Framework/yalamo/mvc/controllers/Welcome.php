<?php 
class Welcome extends Controller {
	
public function Index(){
    $data['title']="Welcom >> Index";
    $data['content']="this is the content of my div from the welcome controller!";
    $this->Load->View("index",$data);
    $m=$this->Model=$this->Load->Model('Users');

   $m->InsertUser("Maniguer");
    
 
}
	
public function Hello()	{
    $data['title'] = 'Welcome >> Hello';
    $data['content'] = 'wellcome hello content';
    $this->Load->View('Welcome',$data);


    
}


}




