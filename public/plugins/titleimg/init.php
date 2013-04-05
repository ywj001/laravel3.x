<?php namespace Plugins\Titleimg;

class Init{ 
    
 	static function view($params){ 
 		 $post = $params['node'];
 		 $title = $params['show_img'];
 	 	 $body = $params['body'];
 		 if(!$post) return;
 		 $title = $post->$title;
		 if(get_img($post->$body))
			$title .= \HTML::image(\URL::base().'/misc/icon/img.png',null,array('width'=>'32px','height'=>'32px'));
		 
		return $title;
 	}
	
	 
	
}