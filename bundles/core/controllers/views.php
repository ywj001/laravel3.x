<?php
/**
 * 自定义BLOCK
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Views_Controller extends Core_Base_Controller {
  	function init(){
  		Menu::active('views');
  	}
 	function action_index(){
 		CMS::set('navigation',__('admin.views lists'));
 	  	$posts = DB::table('views') 
 	  			 ->order_by('sort','desc')
		 	  	 ->order_by('id','desc') 
				 ->paginate(1);
		return View::make('core::views.index')
				->with('posts',$posts);
 	}

}