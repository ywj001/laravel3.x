<?php namespace Plugins\Totop;

class Init{ 
    
 	static function view(){ 
 		\Asset::add('easing', 'plugins/totop/js/easing.js'); 
 		\Asset::add('jquery.ui.totop', 'plugins/totop/js/jquery.ui.totop.js'); 
 		\Asset::add('ui.totop', 'plugins/totop/css/ui.totop.css'); 
 		
 			 
 		\CMS::script('totop',"
 			var defaults = {
	  			containerID: 'toTop', // fading element id
	  			text:'".__('admin.back to top')."',
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 1200,
				easingType: 'linear' 
	 		}; 
			$().UItoTop(defaults);
 		"); 
	  
 	}
	 
	
}