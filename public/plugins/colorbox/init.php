<?php namespace Plugins\Colorbox;
/**
*
<a href="http://www.jacklmoore.com/colorbox/content/ohoopee3.jpg" class='color cboxElement'>test</a>
{{\Plugins\Colorbox\Init::view(array('tag'=>'.color','theme'=>3));}}
*/
class Init{  
 	static function view($params=null){
 		$tag = $params['tag']; 
 		unset($params['tag']);
 		$theme = 1;
 		if($params['theme'])
 			$theme = $params['theme'];
 		unset($params['theme']);
 		 
 		if($params){ 
			$opts = ",".\JS::encode($params);
		}
 		\Asset::add('ckeditor', 'plugins/colorbox/jquery.colorbox.js'); 
 		\Asset::add("colorbox_theme_$theme", "plugins/colorbox/theme$theme/colorbox.css"); 
 		if(!$tag) return;
 		\CMS::script('colorbox_'.$tag,"
 			$('".$tag."').colorbox($opts);
 		"); 
	  
 	}
	 
	
}