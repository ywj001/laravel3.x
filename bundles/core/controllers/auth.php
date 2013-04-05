<?php
/**
 * 权限管理
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Auth_Controller extends Core_Base_Controller {
 	function init(){
 		Menu::active('auth');
 		if(Auth::user()->id!=1) exit('access deny');
 	}
 	function action_index(){  
 		$groups = DB::table('groups')->order_by('id','asc')->get();
 		return View::make('core::auth.index')
 				->with('groups',$groups); 
 	}
 	function action_group_add($id=null){
 	 	if($id){
 	 		$id = (int)$id;
 	 		if($id>0){
 	 			 $post = DB::table('groups')->where('id','=',$id)->first();
 	 			 $post->access = unserialize($post->access);
 	 			 $uu = DB::table('user_group')->where('gid','=',$id)->get();
 	 			 if($uu){
 	 			 	foreach($uu as $ui){
			 	 		$user[] = $ui->uid;
			 	 	}
 	 			 }
 	 		}
 	 	} 
 	  
 	 	$n = DB::table('users')->order_by('id','desc')->get();
 	 	foreach($n as $i){
 	 		$users[$i->id] = $i->username;
 	 	}
 		CMS::set('navigation',__('admin.user group'));
		$view = 'core::auth.group_add';  
		$views =  View::make($view)->with('post',$post)->with('id',$id)->with('users',$users)->with('user',$user); 
		if($_POST){ 
			$input = Input::all();
 			$rules = array(
			    'title'  => "required", 
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{
				$title = trim(Input::get('title'));
				$users = Input::get('users'); 
			 	$access = serialize(Input::get('access'));
			 	$memo = trim(Input::get('memo'));
			 	if($id){
			 		DB::table('user_group')->where('gid','=',$id)->delete();
					DB::table('groups')->where('id','=',$id)
					->update(array('title'=>$title,'access'=>$access,'memo'=>$memo));
				}else{
					$id = DB::table('groups') 
					->insert_get_id(array('title'=>$title,'access'=>$access,'memo'=>$memo));
				}
				if($users){ 
					foreach($users as $uid){
						DB::table('user_group')->insert(array(
							'gid'=>$id,
							'uid'=>$uid
						));
					}
				}
				Cache::forget('auth_access_lists');
				return 1;
			}
		} 
 		return $views;
 		
 	}
 	
 	function action_edit($id){
		$view = 'core::user.edit'; 
		$user = DB::table('users')->where('id','=',$id)->first();
		$views =  View::make($view)
 				->with('user',$user);
		if($_POST){
			$input = Input::all();
 			$rules = array(
			    'old_password'  => "required|max:20|old_password:$id",
			    'password' => 'required|min:6|max:20|confirmed',
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{
				$password = Hash::make(trim(Input::get('password')));
				DB::table('users')
					->where('id','=',$id)
					->update(array('password'=>$password));
				return Redirect::to_action('core/user/index')
						->with('success',__("admin.update #:name# password success",array('name'=>$user->username))); 
			}
		} 
 		return $views;
 		
 	}
 	function action_del($id){
 		$user = DB::table('users')->where('id','=',$id)->first();
 		if($_POST['delete']==1){
 			if($user->id==1 || $user->id == \Auth::user()->id){
 				return Redirect::to_action('core/user/index')
			  	 		->with('error',__("admin.delete user #:name# failed",array('name'=>$user->username))); 
 			}
 			DB::table('users')->where('id','=',$id)->delete();
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