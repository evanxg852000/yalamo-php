<?php

Class Blog extends  WebApplicationController{


	
	Public function Index()
	{
		echo 'je suis le text mvc' ;
	}
	

	Public function Articles()
	{
		$this->registry->View->bg = 'This is the blog heading';
		$this->registry->View->content = 'This is the of my mvc';
		
		$data['v']='grigera';
		$this->registry->View->LoadView('Welcom','Hello',$data);
	}
	


}
?>
