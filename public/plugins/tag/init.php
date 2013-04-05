<?php namespace Plugins\Tag;

class Init{ 
    
 	static function view($params=null){  
 		$tag = $params['tag']?:'.tag';
 		unset($params['tag']);
 		$opts = $params;
 		if($opts)
 			$opt = ",".\JS::encode($opts);
 		\Asset::add('jquery.tagsinput.css', 'plugins/tag/js/jquery.tagsinput.css'); 
 		\Asset::add('jquery.tagsinput.min.js', 'plugins/tag/js/jquery.tagsinput.min.js');  
 		\CMS::script('tagsinput',"$('".$tag."').tagsInput(".$opt.");"); 
	  
 	}
	 
	
}