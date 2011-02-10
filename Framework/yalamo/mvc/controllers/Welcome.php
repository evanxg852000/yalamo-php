<?php 
class Welcome extends Controller {

public function Index(){
    Profiler::CheckPoint("Controller");
    $this->Set("title","Yalamo Framework" );
    $this->Set("content","this is the content of my div from the welcome controller!" );
    $this->Model=$this->Load->Model('Users');

   
       
    $this->Show("index");
    Inspector::Instance()->Investigate(true);
   
}

public function Hello()	{
    $this->Cache(60);
    $this->Delegate($this->Uri->Segment(2));
}

public function License(){
    $this->Show("license");
}

}




