<?php
/**
 * MinCMS ASSET
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class CMS{
	static $_script;
	static $_cute_script;
	static $_style;
	static $_obj;
	static function node_rules($name,$fields){
		foreach($fields as $f){ 
		 	$f = (object)$f;
		 	$f->validate= static::validate_ignor($f->validate); 
			if($f->validate){ 
				$dd = $f->db_type;//
				$table = "content_{$name}_$dd"; 
				$r = implode('|',$f->validate); 
				if(strpos($r,'node_unique')!==false){
					$fid = $f->id;
					$r = str_replace('node_unique',"node_unique:$table,$fid",$r);
				} 
				$rules[$f->value] = $r;
			}
		} 
		return $rules;
	}
	static function validate_ignor($v){
 		if($v){
 			foreach($v as $vo){
	 		  if(strpos($vo,'mimes')===false){
	 		  		$va[] = $vo;
	 		  }
	 		}
 		}
 		return $va;
 	}
	static function array_len($test){
		return strlen(trim(implode('',array_values($test))));
	}
	static function auth(){
		if(!Auth::check()){
	 		$url = action('core/login/index');
	 		header("location:$url");
	 		exit;
	 	}
	}
	//判断有没有显示权限
	static function check($key){
		if(Auth::user()->id==1) return true;
		$access = Cache::get('auth_access_lists');
		if($access[$key]) return true; 
		return false;
	}
	//判断字段是否显示
	static function check_coloum($key){
		if(Auth::user()->id==1) return false;
		$access = Cache::get('auth_access_lists');
		if($access[$key]) return true; 
		return false;
	}
	//列出所有需要配置权限的列表
	static function access_list(){
		$cache = new QCache_PHPDataFile;
		$modules = $cache->get('bundles');  
		$auth['_mincms_only']['self']['action'] = array('update','delete'); 
		if($modules){
			foreach($modules as $k=>$v)
				$auth['module'][$k] = $k ;
		}
		$rows = \DB::table('fields')->where('pid','=',0)
		 	->order_by('sort','desc')
		 	->order_by('id','desc')
		 	->get();
		if($rows){
			foreach($rows as $row){
				$fis = Node::fields_detail($row->value);
				$f = $fis['fields'];
				if($f){
					foreach($f as $ff){
						$fields[$fis['type']->value][$fis['type']->label][]= $ff['value'];
					}
				} 
				$auth['node'][$row->value][$row->label] = array('index','create','update','delete');
			}
		} 
		$auth['system']['taxonomy']['taxonomy'] = array('index','create','update','delete'); 
		$auth['system']['imagecache'] = 'imagecache'; 
		$auth['system']['user']['user'] = array('index','create','update','delete'); 
		$auth['field_exclude'] = $fields;
		return $auth;
	
	}
	static function set($name,$value){
		self::$_obj[$name] = $value;
	}
	static function get($name,$value=null){
		return self::$_obj[$name]?:$value;
	}
	static function script($name,$code){
		if(!isset(self::$_script[$name])){
			self::$_script[$name] = $code;
		}
	}
	static function javascript($name,$code){
		if(!isset(self::$_cute_script[$name])){
			self::$_cute_script[$name] = $code;
		}
	}
	
	static function style($name,$code){
		if(!isset(self::$_style[$name])){
			self::$_style[$name] = $code;
		}
	}
	static function render_javascript(){
		if(self::$_cute_script){
			foreach(self::$_cute_script as $code){
				$str .= $code;
			}
			$out = "<script> $str </script>";
		} 
		return $out;
	}
	
	static function render(){
		if(self::$_script){
			foreach(self::$_script as $code){
				$str .= $code;
			}
			$out = "<script>$(function(){ $str });</script>";
		}
		if(self::$_style){
			foreach(self::$_style as $code){
				$style .= $code;
			}
			$out .= "<style> $style </style>";
		}
		
	 
		return $out;
	}
	
	static function upload($http_url=null){
		$url = "uploads/".date('Y').'/'.date('m').'/'.date('d');
		$dir = path('public').$url; 
		$temp_dir = path('public').'uploads/temp';
		if(!is_dir($dir)) DirHelper::mkdir($dir);
		if(!is_dir($temp_dir)) DirHelper::mkdir($temp_dir);
		if($http_url) {
			return self::_upload($http_url,array(
				'url'=>$url,
				'dir'=>$dir,
				'temp_dir'=>$temp_dir,
			));
		}
		if(!$_FILES)return; 
		foreach($_FILES as $k=>$f){
			$tmp_name = $f['tmp_name'];
			$name = $f['name'];
			$key = uniqid('', true).json_encode($f);
			$name = md5($key).".".File::extension($name);
			$to = $dir.'/'.$name;
			$old = $temp_dir.'/'.$name; 
			move_uploaded_file($tmp_name,$old); 
			$row = self::_upload_db($old,$to,$url.'/'.$name,$f['size'],$f['type']);
			$ret[] = $row;
		}  
	 	return $row;	
	}
	static function _upload($http_url,$ar){
		$name = uniqid('', true).md5($http_url).".".File::extension($http_url);
		$data = @file_get_contents($http_url);
		$old = $ar['temp_dir'].'/'.$name;
		@file_put_contents($old,$data);
	 	$to = $ar['dir'].'/'.$name;  
	 	$size = filesize($old);
	 	if($size<5) {
	 		@unlink($old);
	 		return;
	 	}
	 	$type = filetype($old); 
		$row = self::_upload_db($old,$to,$ar['url'].'/'.$name,$size,$type);
		return $row;
	}
	static function _upload_db($old,$to,$path,$size,$type){
		$data = file_get_contents($old);
		$uniqid =  md5($data);
		$row = DB::table('files')->where('uniqid','=',$uniqid)->first();
		if(!$row){ 
			copy($old,$to);   
			DB::table('files')->insert(
				array(
					'path'=>$path,
					'uniqid'=>$uniqid,
					'size'=>$size,
					'type'=>$type,  
				)
			);  
		}
		else if(!file_exists(path('public').$row->path)){ 
			copy($old,path('public').$row->path);  
		}
		$row = DB::table('files')->where('uniqid','=',$uniqid)->first();

		@unlink($old);
		return $row;
	}
}