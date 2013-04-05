<?php namespace Plugins\Lightbox;
/**
*
 rel='lightbox'
*/
class Init{  
 	static function view($params=null){
 		$tag = $params['tag']; 
 		unset($params['tag']);
 		$theme = 1;
 		if($params['theme'])
 			$theme = $params['theme'];
 		unset($params['theme']);
 		$params['fileLoadingImage'] = \URL::base().'/plugins/lightbox/images/loading.gif'; 
 		$params['fileCloseImage'] = \URL::base().'/plugins/lightbox/images/close.png';
 		$params['labelImage'] = __('admin.image');
 		$params['labelOf'] = '/';
 		  
 		if($params){ 
			$opts = \JS::encode($params);
		}
 		\Asset::add('lightbox', 'plugins/lightbox/js/lightbox.js'); 
 		\Asset::add("lightbox.css", "plugins/lightbox/css/lightbox.css"); 
 		\CMS::script('Lightbox',"
 			$('#lightbox').html('Download Image');
 		");
 	 
	  
 	}
	 
	
}