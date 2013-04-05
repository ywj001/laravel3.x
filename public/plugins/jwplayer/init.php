<?php namespace Plugins\Jwplayer;
/*
<div id="video"></div> 
<?php 
$file = "http://content.bitsontherun.com/videos/3XnJSIm4-kNspJqnJ.mp4";  
$image = "http://content.bitsontherun.com/thumbs/3XnJSIm4-640.jpg";
\Plugins\Jwplayer\Init::view(array(
	'tag'=>'video',
	'file'=>$file,
	'image'=>$image, 
));
?> 
*/
class Init{  
 	static function view($params=null){
 		$tag = $params['tag']; 
 		$key = $params['key']?:"ABCDEFGHIJKLMOPQ";
 		unset($params['tag'],$params['key']); 
 		if($params){ 
			$opts = \JS::encode($params);
		}
 		\Asset::add('jwplayer', 'plugins/jwplayer/misc/jwplayer.js'); 
 	 	if(!$tag) return;
 	 	\CMS::script('jwplayer_'.$tag,"
 	 		jwplayer.key='".$key."';
			jwplayer('".$tag."').setup($opts);
 	 	");
	  
 	}
	 
	
}