<?php
/**
 * 用户管理
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_User_Controller extends Core_Base_Controller {
 	function init(){
 		Menu::active('user');
 	}
 	function action_index(){
 		//判断权限
 		$this->has_access('system.user.index');
 		$users = DB::table('users')->order_by('id','desc')->paginate(20);
 		return View::make('core::user.index')
 				->with('users',$users);
 	}
 	
 	function action_add(){
 		CMS::set('navigation',__('admin.create user'));
 		//判断权限
 		$this->has_access('system.user.create');
		$view = 'core::user.add';  
		$views =  View::make($view); 
		if($_POST){
			$input = Input::all();
 			$rules = array(
			    'username'  => "required|alpha|min:3|max:20|unique:users",
			    'password' => 'required|min:6|max:20|confirmed',
			    'email' => 'required|email',
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{
				$username = trim(Input::get('username'));
				$password = Hash::make(trim(Input::get('password')));
				$email = trim(Input::get('email'));
				DB::table('users') 
					->insert(array('username'=>$username,'password'=>$password,'email'=>$email));
				
				mailer(array($email=>$username),__('admin.welcome to use admin login'),array(
					'{{username}}'=>$username,
					'{{password}}'=>Input::get('password')
				),'add_user');
			 
				Cache::forget('users'); 
				
				return Redirect::to_action('core/user/index')
						->with('success',__("admin.create user #:name# success",array('name'=>$username))); 
			}
		} 
 		return $views;
 		
 	}
 	
 	function action_edit($id){
 		//判断权限
 		$this->has_access('system.user.update',$id);
		$view = 'core::user.edit'; 
		$user = DB::table('users')->where('id','=',$id)->first();
		$views =  View::make($view)
 				->with('user',$user);
		if($_POST){
			$input = Input::all();
			$ps = trim(Input::get('password'));
 			$rules['old_password'] = "required|max:20|old_password:$id";
 			if($id!=Auth::user()->id && $ps)
 				$rules['password'] = "required|min:6|max:20|confirmed";
 			$rules['email'] = "required|email";  
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{ 
				$password = Hash::make($ps);
				$email = trim(Input::get('email'));
				if($ps){
					DB::table('users')
						->where('id','=',$id)
						->update(array('password'=>$password,'email'=>$email));
					mailer(array($email=>$username),__('admin.update admin password'),array(
						'{{username}}'=>$user->username,
						'{{password}}'=>Input::get('password')
					),'update_user');
				}else{
					DB::table('users')
						->where('id','=',$id)
						->update(array('email'=>$email));
				}
				
				
				Cache::forget('users'); 
				return Redirect::to_action('core/user/index')
						->with('success',__("admin.success")); 
			}
		} 
 		return $views;
 		
 	}
 	function action_del($id){
 		//判断权限
 		$this->has_access('system.user.delete');
 		$display = 1;
 		$user = DB::table('users')->where('id','=',$id)->first();
 		if($user->display==1)
 			$display = 0;
 		if($_POST['delete']==1){
 			if($user->id==1 || $user->id == \Auth::user()->id){
 				return Redirect::to_action('core/user/index')
			  	 		->with('error',__("admin.delete user #:name# failed",array('name'=>$user->username))); 
 			}
 			 
 			DB::table('users')->where('id','=',$id)->update(array('display'=>$display)); 
 			Cache::forget('users'); 
 			return Redirect::to_action('core/user/index')
			   ->with('success',__("admin.delete user #:name# success",array('name'=>$user->username))); 
 		}
 		return View::make('core::user.del')
 				->with('user',$user);
 	}
 	function action_cancel(){
 		return Redirect::to_action('core/user/index')
			   ->with('error',__("admin.delete option is canceled")); 
 	}

}