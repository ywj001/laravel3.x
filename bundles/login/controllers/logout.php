<?php
include __DIR__.'/base.php';
/**
 * 第三方登录
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Login_Logout_Controller extends Login_Base_Controller {
 	 
 	public function action_index()
	{ 
		Client::logout();
	    return Redirect::back()
						->with('success',__("admin.logout success")); 
	}
	 

}