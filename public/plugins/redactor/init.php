<?php namespace Plugins\Redactor;

class Init{ 
    
 	static function view($params=null){
 		$tag = $params['tag']; 
		unset($params['tag']);  
		if($params)
			$opts = \JS::encode($params);
 		assets('plugins/redactor/redactor.css'); 
 		assets('plugins/redactor/redactor.zh.js'); 
 		if(!$tag) return;	 
 	 
 		\CMS::script('redactor_'.$tag," 
 			$('".$tag."').redactor($opts);
 			 
 			
 		"); 
	  
 	}
	 
	
}