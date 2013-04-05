<?php 
/**
 * 文件管理
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Filemange_Home_Controller extends Core_Base_Controller {
 	function init(){
 		//判断权限
 		$this->has_access("module.filemange");
 		Menu::active(array('module','filemange'));
 	}
 	function action_index(){  
 		Plugins\Masonry\Init::view(array(
 			'tag'=>'#masonry',
 			'itemSelector'=>'.item',
 			'scroll'=>true,
 		 
 		));  
 		$posts = DB::table('files')->order_by('id','desc')->paginate(50); 
 		return View::make('filemange::home.index')
 				->with('posts',$posts);
 		 
 	}
 	function action_upload(){   
		$rt = CMS::upload(); 
		Session::flash('success',__('core.upload files success'));
		// Return JSON-RPC response
		die(json_encode($rt)); 
 	}

}