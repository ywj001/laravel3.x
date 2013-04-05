<?php namespace Plugins\Checkbox;

class Init{ 
    
 	static function view($params=null){  
 		\Asset::add('iphoneStyle_css', 'plugins/checkbox/style.css'); 
 		\Asset::add('iphoneStyle.js', 'plugins/checkbox/iphone-style-checkboxes.js'); 
 		$params['checkedLabel'] = __("admin.yes");	
		$params['uncheckedLabel'] = __("admin.no");
		$opts = \JS::encode($params);
 		\CMS::script('iphoneStyle'," 
			$('input:checkbox').iphoneStyle($opts);
 		"); 
	  
 	}
	 
	
}