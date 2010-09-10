<?php
Class IndexPage extends  WebApplicationController {
	
	Public function Index()
	{

		$this->registry->View->Title = 'Index Page';
		$this->registry->View->Content = 'The Index Page content';
		$data['Var_Dummy']='Evance';
		
		$this->registry->View->LoadView('IndexPage','index',$data);
	}
	
	
	
}
?>
