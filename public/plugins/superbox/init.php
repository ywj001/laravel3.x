<?php namespace Plugins\SuperBox;
/**
*
http://pierrebertet.net/projects/jquery_superbox/
*/
class Init{  
 	static function view($params=null){
 		$tag = $params['tag']; 
 		unset($params['tag']); 
 		if(!$params['boxId'] && $tag)
 	 		$params['boxId'] = $tag;
 	 	$params['loadTxt'] = __('admin.loading');
 	 	$params['closeTxt'] = __('admin.close');
 	 	$params['prevTxt'] = __('admin.previous');
 	 	$params['nextTxt'] = __('admin.next');
 		if($params){ 
			$opts = \JS::encode($params);
		}
 		\Asset::add('superbox.css', 'plugins/superbox/jquery.superbox.css'); 
 		\Asset::add("superbox.js", "plugins/superbox/jquery.superbox-min.js"); 
 		 
 		if($opts){
 			\CMS::script('superbox_settings_'.$tag," 
 				$.superbox.settings = $opts; 
 			"); 
 		}
 		\CMS::script('superbox'," 
 			$.superbox();
 		"); 
	  
 	}
	 
	
}