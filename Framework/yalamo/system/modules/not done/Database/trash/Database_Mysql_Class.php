<?php
Final Class  DatabaseMysql Extends ADatabase {

	Protected function Connect()
	{
		if(mysql_connect( YALAMO_DB_SERVER, YALAMO_DB_USER,YALAMO_DB_PASSWORD) )
		{
			if(mysql_select_db(YALAMO_DB_NAME))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
		return false;
		}
	}
	
	Public function Request()
	{
		if($this->Connect())
		{
			if ( mysql_query($this->sql) ) 
			{
				mysql_close() ;
				return true;
			}
			else
			{
				mysql_close() ;
				return false;
			}
			
		}
		else
		{
			return false;
		}
	}
	
	Public function Select()
	{
		if($this->Connect())
		{
			$query = mysql_query($this->sql);
			if($query!==false)
			{
				$table=array();
				$nb_colone=mysql_num_fields($query); 			//recuperation du nombre de colone
				$nb_ligne=mysql_num_rows($query); 				//recuperation du nombre de ligne	
				for($i=0;$i<$nb_ligne;$i++)   					//parcours de lignes
					{
						$list=mysql_fetch_row($query); 			//selectione une ligne deplace le pointeur a chaque iteration
						for($j=0;$j<$nb_colone;$j++)
						{
							$nom_colone=mysql_field_name($query, $j); //recuperation du nom de la colone par indice
							$table[$i][$nom_colone]= $list[$j];
						}					
					}
				mysql_close() ;
				return $table;
			}
			else
			{
				mysql_close() ;
				return false;
			}
			//grefine
		}
		else
		{
			return false;
		}
	}
	
	Public function SelectToJson()
	{
		if($this->Connect())
			{
				$query = mysql_query($this->sql);
				if($query!==false)
				{
					$table=array();
					if(mysql_num_rows($query )<=0)
					{
						$table=array( array( "NO RECORD"=>"NO RECORD","NO RECORD"=>"NO RECORD" ));
					}
					else
					{
						while($obj = mysql_fetch_object($query ))
						{
							$table[] = $obj;
						}
							
					}
					mysql_close() ;
					return '{success:true,rows:'.json_encode($table).'}';
				}
				else
				{
					mysql_close() ;
					return false;
				}
			}
			else
			{
			return false;
			}
	}
	
}
?>