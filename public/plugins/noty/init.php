<?php namespace Plugins\Noty;

class Init{ 
    
 	static function view($params=null){ 
 		$tag = $params['type'];
 		\Asset::add('noty.js', 'plugins/noty/misc/js/noty/jquery.noty.js'); 
 	 	\Asset::add('noty.inline.js', 'plugins/noty/misc/js/noty/layouts/inline.js'); 
 		
 		\Asset::add('noty.bottom.js', 'plugins/noty/misc/js/noty/layouts/bottom.js');  
 	 	\Asset::add('noty.bottomCenter.js', 'plugins/noty/misc/js/noty/layouts/bottomCenter.js'); 
 	 	\Asset::add('noty.bottomLeft.js', 'plugins/noty/misc/js/noty/layouts/bottomLeft.js'); 
 	 	\Asset::add('noty.bottomRight.js', 'plugins/noty/misc/js/noty/layouts/bottomRight.js'); 
 	 	\Asset::add('noty.top.js', 'plugins/noty/misc/js/noty/layouts/top.js');  
 	 	\Asset::add('noty.topCenter.js', 'plugins/noty/misc/js/noty/layouts/topCenter.js'); 
 	 	\Asset::add('noty.topLeft.js', 'plugins/noty/misc/js/noty/layouts/topLeft.js'); 
 	 	\Asset::add('noty.topRight.js', 'plugins/noty/misc/js/noty/layouts/topRight.js'); 

 
 		\Asset::add('noty.themes.js', 'plugins/noty/misc/js/noty/themes/default.js');
 		if(!$params['type']) return;
 		unset($params['tag']);
 		if($params){ 
			$opts = \JS::encode($params);
		}
 			 
 		\CMS::script('noty',"
 			  noty($opts);
 		"); 
	  
 	}
	 
	
}