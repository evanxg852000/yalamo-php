<?php

Class ControllerName extends WebApplicationController { 

	
	Public function Index()
	{
		echo 'I am from the mvc' 
	
	}
	
	Public function NameView() //the method name is the name of the view scoped by:  ControllerName_ [NameView] _view
	{

		$this->registry->View->title = 'This is a title';
		$this->registry->View->content = 'This is the content';
		$data['variable']='this is a variable passed throug an array';

		$this->registry->View->LoadView('Welcom','Hello',$data);
		
	}


}
?>
