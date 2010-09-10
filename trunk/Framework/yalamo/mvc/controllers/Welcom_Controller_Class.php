<?php
Class Welcom extends WebApplicationController {
	
	Public function Index()
	{

		$this->registry->View->Title = 'Welcom default';
		$this->registry->View->content = 'welcom default content ';
		$data['v']='';
		
		$this->registry->View->LoadView('Welcom','Hello',$data);
	}
	
	Public function Hello()
	{
		$this->registry->View->Title = 'Wellcom Hello';
		$this->registry->View->content = 'wellcom hello content';
		
		$data['v']='grigera';

		$this->registry->View->LoadView('Welcom','Hello',$data);

	}


}
?>
