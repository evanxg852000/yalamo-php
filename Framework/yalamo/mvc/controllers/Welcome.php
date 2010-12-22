<?php 
class Welcome extends Controller {
	
public function Index(){    
    $this->Set("title","Yalamo Framework" );
    $this->Set("content","this is the content of my div from the welcome controller!" );
    $this->Model=$this->Load->Model('Users');
    $this->Set("paypalinitiation","");

 
 

    $this->Set('users',$this->Model->SelectAll());
    var_dump($this->Variables['users']);
   //
   //$this->Model->Escape();
    //$this->Load->View("index",  $this->Variables);
    Profiler::CheckPoint("Controller");
    $this->Show("index");
    Inspector::Instance()->Investigate(true);
   
}

public function Hello()	{
    $this->Cache(60);
    $this->Delegate($this->Uri->Segment(2));
}


}




