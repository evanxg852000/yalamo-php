<?php 
class Welcome extends Controller {
	
public function Index(){    
    $this->Set("title","Yalamo Framework" );
    $this->Set("content","this is the content of my div from the welcome controller!" );
    $this->Model=$this->Load->Model('Users');
    
    tr("L001");
   


// $s=$this->Component("Sizer");
    //$data["users"]=$this->Model->SelectAll();
   // $this->Model->InsertUser("Evance");
   //$this->Model->Escape();
    //$this->Load->View("index",  $this->Variables);
   Profiler::CheckPoint("Controller");
   $this->Show("index");
   
}
	
public function Hello()	{
    $this->Cache(60);
    $this->Delegate($this->Uri->Segment(2));
}


}




