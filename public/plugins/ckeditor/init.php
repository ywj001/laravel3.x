<?php namespace Plugins\Ckeditor;

class Init{ 
    
 	static function view($params){
 		$tag = $params['tag']; 
 		$tag = str_replace('#','',$tag);
 		if($params['upload']===true){
 			$base = \URL::base()."/plugins/ckeditor/misc";
			$params['filebrowserBrowseUrl'] = 	 $base.'/php/ckfinder.html';
			$params['filebrowserImageBrowseUrl'] = 	 $base.'/php/ckfinder.html?Type=Images';
			$params['filebrowserFlashBrowseUrl'] = 	 $base.'/php/ckfinder.html?Type=Flash';
			$params['filebrowserUploadUrl'] = 	 $base.'/php/core/connector/php/connector.php?command=QuickUpload&type=Files';
			$params['filebrowserImageUploadUrl'] = $base.'/php/core/connector/php/connector.php?command=QuickUpload&type=Images';
			$params['filebrowserFlashUploadUrl'] = $base.'/php/core/connector/php/connector.php?command=QuickUpload&type=Flash'; 
		}
		unset($params['upload'],$params['tag']);
		if($params)
			$opts = ",".\JS::encode($params);
 		\Asset::add('ckeditor', 'plugins/ckeditor/misc/ckeditor.js'); 	 
 		\CMS::script('ckeditor_'.$tag,"
 			CKEDITOR.replace('".$tag."'$opts);
 			$('form').submit(function(){
 				$('#".$tag."').val(CKEDITOR.instances.".$tag.".getData());
 			});
 			
 		"); 
	  
 	}
	 
	
}