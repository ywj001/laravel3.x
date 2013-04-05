<?php namespace Plugins\imgPreview;

class Init{ 
    
 	static function view($params=null){  
 		\Asset::add('imgpreview', 'plugins/imgPreview/imgpreview.full.jquery.js');  
 		$tag = $params['tag']?:'.img'; 
 		unset($params['tag']);
 		if($params){ 		
			$opts = ",".\JS::encode($opts);
		}
 	 
 		\CMS::script('imgPreview'.$tag,"
 			$('".$tag."').imgPreview($opts);
 		");  
	  
 	}
	 
	
}