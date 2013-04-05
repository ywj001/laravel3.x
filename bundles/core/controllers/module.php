<?php
/**
 * 模块
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Module_Controller extends Core_Base_Controller {
 	function init(){
 		Menu::active(array('module','module_index'));
 		if(Auth::user()->id!=1)
 			throw new Exception('access deny'); 
 	}
 	public function action_index(){ 
 		$dirs = scandir(path('bundle'));
 		$ex = array('.','..','.svn','.gitignore','core','docs');
 		$db = DB::table('bundles')->get();
 		$modules = array();
 		if($db){
 			foreach($db as $d){ 
 				$modules[$d->name] = $d->name;
 				$old[$d->name] = $d->name;
 			}
 		}
 		foreach($dirs as $dir){ 
 			if(!in_array($dir,$ex)){
 				$info = @include path('bundle').$dir.'/info.php';
 				$menu = @include path('bundle').$dir.'/menu.php'; 
 				if(!file_exists(path('bundle').$dir.'/lock')) continue;
 				$post[$dir]['name'] = $dir;
 				$post[$dir]['info'] = $info;
 				$post[$dir]['menu'] = $menu;
 				$new[$dir] = $dir;
 			}
 		} 
 		if($old && $new){
 			$news = array_diff($old,$new);
 			if($news){
 				DB::table('bundles')->where_in('name',$news)->delete();
 				$this->cache();
 			}
 		}
 		return View::make('core::module.index')
 			   ->with('post',$post)
 			   ->with('modules',$modules);
 	}
 	
 	public function action_able($name){
 		$post = DB::table('bundles')->where('name','=',$name)->first();
 		if(!$post){
 			DB::table('bundles')
 				->insert(array('name'=>$name));
 			$msg = __("admin.enable module #:name# success",array('name'=>$name)); 
 		}else{
 			DB::table('bundles')->where('name','=',$name)->delete();
 			$msg = __("admin.disable module #:name# success",array('name'=>$name));
 			
 		}
 		$this->cache();
 		return Redirect::to_action('core/module/index')
						->with('success',$msg); 
 		
 		
 	}
 	protected function cache(){
 		$cache = new QCache_PHPDataFile; 
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