<?php namespace Plugins\Gallery;
/**
*  https://github.com/blueimp/jQuery-Image-Gallery'
*/
class Init{ 
    
 	static function view($p){ 
 		$tag = $p['tag']; 
 		$theme = $p['theme']?:'classic'; 
 		unset($p['tag'],$p['theme']);
		$base = \URL::base().'/plugins/gallery/assets'; 
		if($p){
	 		$opts = JS::encode($p);
		}  
	 	assets($base.'/galleria-1.2.8.min.js');  
	 	assets($base."/themes/".$theme."/galleria.".$theme.".css"); 
	 	if(!$tag) return;
		\CMS::script('imagegallery_'.$tag,"
		Galleria.loadTheme('".$base."/themes/".$theme."/galleria.".$theme.".js');
		Galleria.configure(".$opts.");
		Galleria.run('".$tag."');"); 
 			 
 	 
	  
 	}
	 
	
}