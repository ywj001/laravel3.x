<?php namespace Plugins\Farbtastic;

class Init{ 
    
 	static function view($params=null){ 
 		$tag = $params['tag'];
 		$to = $params['to'];
 		\Asset::add('farbtastic.css', 'plugins/farbtastic/misc/farbtastic.css'); 
 		\Asset::add('farbtastic.js', 'plugins/farbtastic/misc/farbtastic.js');  
 		unset($params['tag']);
 		if(!$tag) return;	 
 		\CMS::script('farbtastic'.$tag,"
 			$('".$tag."').farbtastic('".$to."');
 		"); 
	  
 	}
	 
	
}