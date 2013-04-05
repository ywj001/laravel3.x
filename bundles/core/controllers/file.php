<?php 
/**
 * 上传文件
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_File_Controller extends Core_Base_Controller {
 	function init(){
 		//Menu::active('module');
 	}
 	function action_index(){   
 		return View::make('core::home.index');
 	}
 	function action_upload(){   
 		$name = $_REQUEST['field'];

 		if(!$name) exit;
		$rt = CMS::upload(); 
		 
		if(!$rt) return;

		$new[] = $rt; 

		$out = Helper::cck_files($new,$name);
		$rt->tag = $out;
		die(json_encode($rt)); 
 	}

}