<?php namespace Plugins\Datepicker;

class Init{ 
    
 	static function view($params=null){
 		$tag = $params['tag'];  
		unset($params['tag']);
		if($params)
			$opts = \JS::encode($params);
 		assets('misc/jui/jquery-ui.js'); 
 		 
 		assets('plugins/datepicker/jquery-ui-timepicker-addon.js'); 	
 		assets('plugins/datepicker/css.css'); 	
 	 
 		
 		\CMS::script('datepicker_'.$tag,"
 			
 			$( '".$tag."' ).datetimepicker($opts); 
 		"); 
	  
 	}
	 
	
}