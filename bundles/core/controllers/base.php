<?php
/**
 * 后台权限基类
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Base_Controller extends Base_Controller {
  	 
	function __construct()
	{
		parent::__construct();
		//\Modules\Minify\Init::view();
		//Config::set('language','zh');
	 	if(!Auth::check()){
	 		$url = action('core/login/index');
	 		header("location:$url");
	 		exit;
	 	}
	 	//生成权限缓存
	 	$this->_auth();
	 	//生成管理列表缓存
	 	$this->cache_users();
	 	//语言切换
	 	$this->_i18n();
	 	$cache = new QCache_PHPDataFile;
		$data = $cache->get('bundles'); 
		if(!$data){
			$db = DB::table('bundles')->get(); 
	 		if($db){
	 			foreach($db as $d){
	 				$name = $d->name;
	 				$modules[$name] = array('handles'  => $name);
	 			}
	 		} 
	 		if($modules)
				$cache->set('bundles',$modules); 
		}
	} 
	//语言切换
	function _i18n(){
		$lan = Helper::theme_language('language_admin','language',true)?:'en';   
		Config::set('application.language',$lan);
	}
	function has_access($key,$id=0){ 
		if(Auth::user()->id==1) return true;
		$access = Cache::get('auth_access_lists');   
		//dump($access);
		if(!$access[$key]) $tag = false; 
	 	 
		if($id>0 ){
			$way = substr($key,strrpos($key,'.')+1);
			if($access["_mincms_only.self.$way"]){
				if(Auth::user()->id!=$id) 
					$tag = false;
			}
			 
		}
		if(false === $tag)
			exit('access deny');
	}
	function cache_users(){
		if(!Cache::get('users')){
			$users = \DB::table('users')->get();
			foreach($users as $u){
				$u->memo = (object)unserialize($u->memo);
				$o[$u->id] = $u;
			} 
			Cache::forever('users', $o); 
		}
	 
	}
	function _auth(){ 
		if(!Cache::get('auth_access_lists')){
			if(Auth::user()->id!=1){
				$posts = DB::table('user_group')->where('uid','=',Auth::user()->id)->get();
				if($posts){
					foreach($posts as $p){
						$ids[] = $p->gid;
					} 
					$post = DB::table('groups')->where_in('id',$ids)->get();
	 	 			if($post){ 
	 	 				foreach($post as $vo){
	 	 					$ac = unserialize($vo->access); 
	 	 					if(!is_array($ac)) continue;
	 	 					foreach($ac as $k=>$c){
	 	 						if(!is_array($c)){
		 	 						if(!$_access_lists[$k])
		 	 							$_access_lists[$k] = $c;
		 	 						else
		 	 							$_access_lists[$k] = array_merge($_access_lists[$k],$c);
	 	 						}else{ 
	 	 							foreach($c as $_k=>$_c){
	 	 								if(!$_access_lists[$k][$_k])
			 	 							$_access_lists[$k][$_k] = $_c;
			 	 						elseif(is_array($_c))
			 	 							$_access_lists[$k][$_k] = array_merge($_access_lists[$k][$_k],$_c);
	 	 							}
	 	 						}
	 	 					}
	 	 				}
	 	 			  	if($_access_lists){ 
	 	 			  		foreach($_access_lists as $key=>$value){  
	 	 			  			foreach($value as $k=>$v){
	 	 			  				$list = $key.'.';
	 	 			  				$list .= $k.'.';
	 	 			  				if(!is_array($v)) {
	 	 			  					$uni = substr($list,0,-1);
		 	 			  				$lists[$uni] = $uni;
		 	 			  				continue;
	 	 			  				}
	 	 			  				foreach($v as $_k=>$_v){ 
	 	 			  					$uni = $list.$_k;
	 	 			  					$lists[$uni] = $uni;
	 	 			  				}
	 	 			  				
	 	 			  			}
	 	 			  			
	 	 			  		}
	 	 			  	}
	 	 			}
				}
				Cache::forever('auth_access_lists', $lists); 
			}
		} 
	}

}