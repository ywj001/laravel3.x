<?php
/**
 * ÍË³ö
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Logout_Controller extends Base_Controller {
 	public $restful = true;
 	function get_index(){
 	 	Auth::logout();
		return Redirect::to_action('core/login/index')
				->with('success',__('admin.logout success'));
 	 
 	}

}