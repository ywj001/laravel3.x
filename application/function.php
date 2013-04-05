<?php
/**
* <img src="{{imagecache('uploads/1.jpg',1)}}" />
*/
function imagecache($file,$type){ 
	if(!in_array(ext($file),array('jpg','png','gif','bmp','jpeg'))) return;
	if(strpos($file,URL::base())!==false)
		$file = str_replace(URL::base().'/','',$file);
 	$file = '//'.substr($file,0,strrpos($file,'.'))."_imagecache".$type.".".ext($file); 
 	$file = str_replace('//uploads/','uploads/imagecache/',$file); 
 	if($file)
 		$out = URL::base().'/'.$file; ;
	return $out;
}
function plugin($name,$params=null,$d= 'Init',$function='view'){
	$class = "Plugins\\".ucfirst($name)."\\$d";  
	if(method_exists ($class,$function))
		return call_user_func($class.'::'.$function,$params); 
}
 
function node_restore($name,$field,$value,$post){ 
	if($field=='uid'){
		$users = Cache::get('users'); 
		$usr = $users[$value];
		return $usr->username;
	}
	$r = Node::fields_detail($name);
	$orm = $r['fields'][$field]['orm'];
	if($orm){
		$ro = node($orm['table'],$value);
		$_f = $orm['field']?:'id';
		$value = $ro->$_f;
	}
	$class = "\Hooks\Node\\".ucfirst($name); 
	$method = strtolower($field);
	if(method_exists ($class,$method))
		return call_user_func($class.'::'.$method,$post); 
	return $value;
}

function node_restore_plugin($name,$fields,$field,$value,$post){ 
	$plugins = $fields[$field]['plugins'];
	if(!$plugins) return $value;
	foreach($plugins as $k=>$p){ 
		if($p['is_node_index']==1){
			$p['node'] = $post;  
			return plugin($k,$p);
		}
	}
	
}
function hook_url($name,$function){
	 return action('core/hook/index',array('name'=>$name,'function'=>$function));
}
function plugin_url($name,$function){
	 $fun = explode('.', $function);
	 $function = $fun[0];
	 unset($fun[0]);
	 if($fun){
	 	foreach ($fun as $value) {
	 		$value = str_replace('#', '',$value);
	 		$str .= $value.'___';
	 	}
	 }
	 return action('core/plugin/index',array('name'=>$name,'function'=>$function)).'?id='.$str;
}
function plugin_parse($arr){
	$id = $arr['id'];
	$a = explode('___', $id);
	foreach ($a as $key => $value) {
		if($value)
			$out[] = $value;
	}
	return $out;
}
function node_one($name,$params=null,$display=true){
	$params['limit'] = 1;
	if(!$params){

	}
	elseif(!is_array($params)) return Node::one($name,$params);
	
	return node($name,$params,$display);
	
}
function load($name,$path='libraries'){
	static $_load = array();
	if(!isset($_load[$name])){
		$_load[$name."#include"] = include path('app').DS.$path.DS.$name.'.php';
		$_load[$name] = new $name();
	}
	return $_load[$name];
}

function node($name,$params=null,$display=true){
	if(null == $params || is_array($params)){
		if($params['where']){ 
			$where = $params['where'];
		}
		if($display===true)
			$params['where'] = array(array('display','=',1));
		if($where && $display===true){
			$params['where'] = array_merge($params['where'],$where); 
		} 
		$node = Node::find_all($name,$params);
		if($params['limit']==1){
			if($node){
				foreach($node as $n){
					$out = $n;
				}
			}
			return $out;
		}
		return $node;
	}
	else{
		$node = Node::one($name,$params);
		if($node->display!=1)return;
		return $node;
	}
} 
 
/**
* @foreach ($posts->results as $post) 
* @endforeach
* $posts->links()
*/
function node_pager($name,$params=null){
	if($params['where']){ 
		$where = $params['where'];
	}
	$params['where'] = array(array('display','=',1));
	if($where){
		$params['where'] = array_merge($params['where'],$where); 
	}
  
	return Node::pager($name,$params);
}
function node_save($name,$row,$uid=null){
	$row = (array)$row; 
	$uid = $uid?:\Auth::user()->id;
	return Node::save($name,$row,$uid);
}
function name_assets($name,$file){ 
	 return \Asset::container($name)->add(md5($file), $file); 
}
function name_assets_show($name,$type = 'scripts'){ 
	 return \Asset::container($name)->scripts(); 
}
function assets($names){
	if(is_array($names)){
		foreach($names as $name){
			_assets($name);
		}	
	}else{
		_assets($names);
	}
	
}
function _assets($name){
	$t = md5($name);
	\Asset::add($t, $name); 
}
function pr($str){ dump($str);}
function dump($str){
	print_r('<pre>');
	print_r($str);
	print_r('</pre>');
}
function ext($name){
	$find = strrpos($name,'.');
	return strtolower(substr($name,$find+1));
} 
function file_name($name){ 
	return substr($name,strrpos($name,'/')+1,strrpos($name,'.'));
} 
function change_name($name,$ext='jpg'){ 
	$sub = substr($name,0,strrpos($name,'.'));
	return $sub.'.'.strtolower($ext);
}
function sub_domain($name=null){
	if(!$name) $name = URL::base();
	$name = substr($name,strpos($name,'//')+2);
	$e = count(explode('.',$name))-1; 
	if($e==2)
		 return substr($name,0,strpos($name,'.')); 
}
 
function domain($name=null){
	if(!$name) $name = URL::base();
	$len = strpos($name,'//'); 
	return substr($name,$len+2); 
}
function get_local_img($content,$all=false){ 
	$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'; 
	preg_match_all($preg,$content,$out);
	$img = $out[2];
	if($img) { 
		$num = count($img); 
		for($j=0;$j<$num;$j++){ 
			$i = $img[$j]; 
			if( (strpos($i,"http://")!==false || strpos($i,"https://")!==false ) && strpos($i,URL::base())===false)
			{
				unset($img[$j]);
			}
		}
	}
	if($all === true){
		return $img;
	}
	return $img[0]; 
} 
function preg_img($content){
	$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'; 
	preg_match_all($preg,$content,$out);
	unset($out[1]);
	$out = array_merge($out,array());
	return $out;
}
function get_img($content,$all=false){ 
	$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'; 
	preg_match_all($preg,$content,$out);
	$img = $out[2];  
	if($all === true){
		return $img;
	}
	return $img[0]; 
} 
function remove_img($content,$all=false){ 
	/*$preg = "/<img(.*)src=\"(.+?)\".*?>/"; */
	$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
	$out = preg_replace($preg,"",$content);
	return $out;
} 
function img_wh($img){
	$a = getimagesize(root_path().$img);
	return array('w'=>$a[0],'h'=>$a[1]);
}
function array_to_string($data){
	return  (is_array($data) ? http_build_query($data) : $data);
}
function mailer($to,$title,$array=array(),$file){
	$mailer = new MailHelper; 
	$body = $input['body']; 
	$path = path('app')."/mailer/$file".'.php';
	$lang_path = path('app')."/mailer/$file".'_'.get_language().'.php';
	if(file_exists($lang_path))
		$path = $lang_path;
	if(!file_exists($path))
		return;
	$content = @file_get_contents($path); 
	if(!$content) return;
	$content = new_replace($content, $array); 
	$mailer->send($to,$title,$content);
}
function new_replace($body,$replace=array()){ 
	if(!$replace) return $body;
	foreach($replace as $k=>$v){
		$body = str_replace($k,$v,$body);
	}
 	return $body;
}
function minify(){
	\Event::listen('view.filter', function($view){
		 return Minfy::minify($view);
	});
}
function encode($value){
	return Crypter::encrypt($value);
}
function decode($value){
	return Crypter::decrypt($value);
}

function theme($name){
	$theme = Config::get('mincms.theme'); 
	$default_theme = Config::get('mincms.default_theme'); 
	$name = str_replace('.',DS,$name);
	$path = path('public');
 	$theme = 'themes'.DS.$theme;
 	$default_theme = 'themes'.DS.$default_theme;
	$theme = $path.DS.$theme.DS.$name;
	$layout = $path.DS.$theme; 
	$blade = $theme.BLADE_EXT;
	$php = $theme.EXT;
 	$default = $path.DS.$default_theme.DS.$name; 
	if(file_exists($blade) ){  
		$theme = $blade;
	} else if(file_exists($php)){ 
		$theme = $php;
	}else if(file_exists($default.BLADE_EXT)){  
		$theme = $default.BLADE_EXT; 
	}
	else if(file_exists($default.EXT)){ 
		$theme = $default.EXT;
	}  else{
		 throw new Exception('view not find');
	}
 
	return View::make('path: '.$theme);
} 

function theme_assets($file){
	$theme = Config::get('mincms.theme'); 
 	if(is_array($file)){
 		foreach($file as $f){
 			$ff[] = 'themes/'.$theme.'/'.$f;
 		}
 	}else{
 		$ff = 'themes/'.$theme.'/'.$file;
 	}
 	return assets($ff);
}
function theme_url($url=null){
	$theme = Config::get('mincms.theme');  
	if($url)
 		return URL::base().'/themes/'.$theme.'/'.$url; 
 	return URL::base().'/themes/'.$theme.'/';
}
function theme_layout($name){
	$theme = Config::get('mincms.theme'); 
 	$path = path('public').'themes';
	$layout = $path.DS.$theme;   
	$f  = "$layout".DS."$name".BLADE_EXT; 
	if(!file_exists($f)){
		$f = $path.DS.CMS::get('mincms.default_theme').DS."$name".BLADE_EXT;
	} 
	$name  = str_replace('.',DS,$name);
	return "path: ".$f;
}
function import($name){
	include_once path('app')."vendor/{$name}.php";
}
function refer(){
	return $_SERVER['HTTP_REFERER']; 
}
function language($lang='zh'){
	//ÓïÑÔÇÐ»» 
	$lan = Helper::theme_language('language','language',true)?:$lang;   
	Config::set('application.language',$lan); 
	return $lan;
}
function set_language($lang='zh'){ 
	Config::set('application.language',$lang);  
}
function get_language(){ 
	return Config::get('application.language');  
}
function http($url){
	return URL::base().'/'.$url;
}

function node_i18n($name,$id){
	global $i18n;
	$agent = load('agent');
	$node = node($name,$id);
    if($i18n == true){ 
	 	$node_lang =  node($name.'_en',array('limit'=>1,'where'=>array(array('lang','=',$id))));   
	  
	 	if($node_lang){
	 		foreach($node as $k=>$v){
	 			if($node_lang->$k && $k!='id' && $k!='uid')
	 				$node->$k = $node_lang->$k;
	 			
	 		}
	 	}  
	} 
	return $node;
}
 