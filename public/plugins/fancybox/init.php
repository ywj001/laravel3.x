<?php namespace Plugins\Fancybox;
/**
* <a class="fancybox" rel="group" href="big_image_1.jpg"><img src="small_image_1.jpg" alt="" /></a>
* fancybox.ajax
*/
class Init{  
 	static function view($params=null){
 		$tag = $params['tag'];  
 		//assets('plugins/fancybox/fancybox/lib/jquery.mousewheel-3.0.6.pack.js'); 
 		assets('plugins/fancybox/fancybox/source/jquery.fancybox.css'); 
 		assets('plugins/fancybox/fancybox/source/jquery.fancybox.js'); 
 		/*
 		assets('plugins/fancybox/fancybox/source/helpers/jquery.fancybox-buttons.css'); 
 		assets('plugins/fancybox/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5'); 
 		assets('plugins/fancybox/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5'); 
 		assets('plugins/fancybox/fancybox/source/helpers/jquery.fancybox-thumbs.css'); 
 		assets('plugins/fancybox/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7'); */
		unset($params['tag']);
		if(!$tag) return;
		if($params)
			$opts = \JS::encode($params);
 	 	 
 		\CMS::script('fancybox_'.$tag,"
 			$('".$tag."').fancybox($opts);
 			
 		"); 
	  
 	}
	 
	
}