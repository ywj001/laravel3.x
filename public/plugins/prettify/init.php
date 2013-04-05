<?php namespace Plugins\Prettify;

class Init{ 
    
 	static function view($params=null){   
 		$opts = $params;
 		if($opts)
 			$opt = \JS::encode($opts);
 		assets('plugins/prettify/google-code-prettify/prettify.js'); 
 	 	assets('plugins/prettify/google-code-prettify/prettify.css'); 
 	 	assets('plugins/prettify/sons-of-obsidian.css');
 	 	
 		\CMS::script('prettify',"
 		$('pre').addClass('prettyprint');
     	prettyPrint();");  
 	}
	 
	
}