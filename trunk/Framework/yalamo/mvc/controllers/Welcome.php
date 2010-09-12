<?php 
class Welcome extends Controller {
	
public function Index(){
   $this->Load->View("index");	
}
	
public function Hello()	{
    $data['title'] = 'Welcome >> Hello';
    $data['content'] = 'wellcome hello content';
    $this->Load->View('Welcome',$data);

    
}


}

