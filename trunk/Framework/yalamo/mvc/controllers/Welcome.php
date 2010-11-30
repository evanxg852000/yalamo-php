<?php 
class Welcome extends Controller {
	
public function Index(){
    $this->Set("title","Yalamo Framework" );
    $this->Set("content","this is the content of my div from the welcome controller!" );
   
   
    $this->Load->Module("Database");

   


   
   //$db=Database::Parallel("ebookstore");
   //echo "<pre>";
   // _y($db->q("SELECT* FROM links ; ")->ResultSet()->AsAssoc());
   // echo "</pre>";
//_y($data);

    
  

   // $s=$this->Component("Sizer");
   // $this->Model=$this->Load->Model('Users');
    //$data["users"]=$this->Model->SelectAll();
   // $this->Model->InsertUser("Evance");
   //$this->Model->Escape(); 
   Profiler::CheckPoint("Controller");
   $this->Show("index");
   //$this->Load->View("index",  $this->Variables);
}
	
public function Hello()	{
    

    $this->Delegate($this->Uri->Segment(2));
}


}




