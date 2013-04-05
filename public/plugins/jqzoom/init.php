<?php namespace Plugins\Jqzoom;

class Init{ 
    
 	static function view(){  
 		\Asset::add('jqzoom.js', 'plugins/jqzoom/js/jquery.jqzoom-core.js'); 
 		\Asset::add('jqzoom.css', 'plugins/jqzoom/css/jquery.jqzoom.css'); 
 		
 		
 		$tag = $params['tag']?:'.jqzoom'; 
 		unset($params['tag']);
 		if($params){ 		
			$opts = ",".\JS::encode($opts);
		}
 	 
 		\CMS::script('jqzoom'.$tag,"
 			$('".$tag."').jqzoom($opts);
 		");  
	  
 	}
	 
	
}