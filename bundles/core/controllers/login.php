<?php
/**
 * 登录
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Login_Controller extends Base_Controller {
 	
 	function action_index(){
 		$lan = Helper::theme_language('language','language',false)?:'en';   
 		Config::set('application.language',$lan);
 		if($_POST){
 			$input = Input::all();
 			$rules = array(
			    'username'  => 'required|max:10',
			    'password' => 'required|max:20',
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return View::make('core::user.login') 
						->with('validation',$validation->errors);
			     
			}
			$input = (array)$input; 
			unset($input['csrf_token']); 
			if (!Auth::attempt($input))
			{
			     return View::make('core::user.login') 
			     	 	->with('error',true);
			}
			return Redirect::to_action('core/home/index')->with('success',__('admin.login success'));
 		}
 		return View::make('core::user.login');
 	}

}