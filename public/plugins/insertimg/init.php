<?php namespace Plugins\Insertimg;

class Init{ 
    
 	static function view($params){
 		$tag = $params['tag'];
 		$url = plugin_url('insertimg',"get_image.$tag");
		echo "<a  class='hand fancybox fancybox.ajax' href='".$url."'>添加图片</a>"; 
 	}
	
	static function get_image($arr){
		$a = plugin_parse($arr);
		$img = $a[0];//字段
		$data = \DB::table('files')->order_by('id','desc')->paginate(12); 
		include __DIR__.'/album.php';
	}
	
}