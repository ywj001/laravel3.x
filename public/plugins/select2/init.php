<?php namespace Plugins\Select2;

class Init{ 
    
 	static function view($params=null){  
 		 
 		\Asset::add('select2.js', 'plugins/select2/js/select2.js'); 
 		\Asset::add('select2.css', 'plugins/select2/js/select2.css');  
	 	 
 		\CMS::script('select2',"$('select').select2();"); 
	  
 	}
	 
	
}