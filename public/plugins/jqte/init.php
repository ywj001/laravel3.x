<?php namespace Plugins\Jqte;

class Init{ 
    
 	static function view($params=null){
 		$tag = $params['tag']; 
 		$zh = $params['zh']; 
		unset($params['tag'],$params['zh']);
		if($zh){
		 	$params['titletext'][]['title'] = '字体大小';
		 	$params['titletext'][]['title'] = '颜色';
		 	$params['titletext'][]['title'] = '加粗';
		 	$params['titletext'][]['title'] = '斜体';
		 	$params['titletext'][]['title'] = '下划线';
		 	$params['titletext'][]['title'] = '列表';
		 	$params['titletext'][]['title'] = '无序列表';
		 	$params['titletext'][]['title'] = '下标';
		 	$params['titletext'][]['title'] = '上标';
		 	$params['titletext'][]['title'] = '左缩进';
		 	$params['titletext'][]['title'] = '右缩进';
		 	$params['titletext'][]['title'] = '左对齐';
		 	$params['titletext'][]['title'] = '居中';
		 	$params['titletext'][]['title'] = '右对齐';
		 	$params['titletext'][]['title'] = '删除线';
		 	$params['titletext'][]['title'] = '添加链接';
		 	$params['titletext'][]['title'] = '移除链接';
		 	$params['titletext'][]['title'] = '清除样式';
		 	$params['titletext'][]['title'] = '水平线';
		 	$params['titletext'][]['title'] = '源码'; 
	 		$params['button'] = '确认';
 		}
		if($params)
			$opts = \JS::encode($params);
		if($zh)
 			assets('plugins/jqte/js/jquery-te-1.3.3.js'); 
 		else
 			assets('plugins/jqte/js/jquery-te-1.3.3.min.js'); 
 		assets('plugins/jqte/js/jquery-te-1.3.3.css'); 
 		
 		if($params['css'])
 			assets('plugins/jqte/js/'.$params['css'].'.css'); 
 		if(!$tag) return;	 
 		
 		\CMS::script('jqueryte_'.$tag,' 
 			$("'.$tag.'").jqte('.$opts.'); 
 		'); 
	  
 	}
	 
	
}