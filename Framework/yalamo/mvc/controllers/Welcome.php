<?php 
class Welcome extends Controller {
	
public function Index(){
    $data['title']="Yalamo Framework";
    $data['content']="this is the content of my div from the welcome controller!";
    $this->Load->Module("Database");
    
   // $s=$this->Component("Sizer");
   // $this->Model=$this->Load->Model('Users');
    //$data["users"]=$this->Model->SelectAll();
   // $this->Model->InsertUser("Evance");
   //$this->Model->Escape(); 
   Profiler::CheckPoint("Controller");
   $this->Load->View("index",$data);
}
	
public function Hello()	{
    $this->Delegate($this->Uri->Segment(2));
}


}




