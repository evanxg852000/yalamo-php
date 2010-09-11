<?php
class Welcome extends Controller {
	
public function Index(){
      $this->Load->View("index");
        
		
}
	
public function Hello()	{
    $this->View->Title = 'Wellcom Hello';
    $this->View->content = 'wellcom hello content';
    $data['v']='grigera';
    $this->View->LoadView('Welcom','Hello',$data);

    
}


}

