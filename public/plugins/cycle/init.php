<?php namespace Plugins\Cycle;
/**
*
array(
	'fx'=>'fadeZoom', 
	'pager'=> '#cycle_pager' 
)
*/
class Init{ 
    
 	static function view($params=null){ 
 		$tag = $params['tag'];
 		$flag = $params['lite']?true:false;
 		unset($params['tag'],$params['lite']);
 		if(true===$flag)
 			assets('plugins/cycle/jquery.cycle.lite.js'); 
 		else
 			assets('plugins/cycle/jquery.cycle.all.js');  
 	 	
 		if(!$tag) return;	 
 		if($params)
 			$opts = \JS::encode($params);
 		
 		\CMS::script('cycle'.$tag,"
 			if($('".$tag."').length > 0){
				$('".$tag."').cycle(".$opts.");
		    } 
 		"); 
	  
 	}
	 
	
}