<?php
Final Class WebApplication {
	
	Private $ApplicationDb;
	Private $ApplicationVars=array();
	
	function __construct()
	{
		# Neccessary Packages 
		YalImport("YAL.PHP.PAC.Webapplication") ;
		YalImport("YAL.PHP.PAC.Database");
		YalImport("YAL.PHP.PAC.Url");
		
		# Optional Packages
		
		
		# Utilities
		YalImport("YAL.PHP.UTILIS");
		
		$this->ApplicationDb = Database::GetInstance(); 
		$this->ApplicationVars[]='';
		$this->ApplicationVars[]='';
	}
	
	function Build()
	{
		error_reporting(E_ALL);
		
		 # The registry object 
		 $registry = new WebApplicationRegistry();
		
		 # create the database registry object ***/
		 // $registry->db = db::getInstance();
		 
		 
		 # The  mediator
		 $registry->Mediator = new WebApplicationMediator($registry);
		
		 # The view instance
		 $registry->View = new WebApplicationView($registry);
		
		 # Loading  the controller 
		 $registry->Mediator->LoadController();
		
	}
}
?>