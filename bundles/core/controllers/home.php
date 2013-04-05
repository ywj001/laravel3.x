<?php
/**
 * 管理员首页
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Home_Controller extends Core_Base_Controller {
 	
 	function action_index(){
 		Menu::active('home');
 		return View::make('core::home.index');
 	}

}