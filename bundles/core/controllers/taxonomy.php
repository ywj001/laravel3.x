<?php
/**
 * 自定义内容字段
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Taxonomy_Controller extends Core_Base_Controller {
	public $tree;
 	function init(){
 		Menu::active(array('system')); 
 		CMS::set('select2',true);
 		$rows = DB::table('taxonomy')->get();
 		$this->tree = TreeHelper::toTree($rows); 
 	
 	}
 	function action_index($taxonomy_id=0){  
 		//判断权限 
 		$this->has_access("system.taxonomy.index");
 		Menu::active(array('system','taxonomy'));  
 		if(isset($_GET['taxonomy_id'])) 
 				$taxonomy_id = $_GET['taxonomy_id'];
 		if($taxonomy_id>0){
  			$_GET['taxonomy_id'] = $taxonomy_id; 
  			$f = DB::table('taxonomy')
 				->where('id','=',$taxonomy_id)->first(); 
 			$top = 1;
 			if($f->pid>0) 
 				$_GET['back_taxonomy_id'] = $f->pid;
  		} 
  	 
 		$taxonomy = DB::table('taxonomy')
 				->where('pid','=',$taxonomy_id)
 				->order_by('sort','desc')
 				->order_by('id','asc')
 				->get();
 		
 		return View::make('core::taxonomy.index')
 				->with('top',$top)   
 				->with('taxonomy',$taxonomy);
 	}
 	
 	function action_add(){
 		//判断权限 
 		$this->has_access("system.taxonomy.create");
 		$url = action('core/taxonomy/add').Helper::get();
 		$taxonomy_id = (int)$_GET['taxonomy_id']?:0;
 		$view = 'core::taxonomy.form';  
		$views =  View::make($view)
					->with('url',$url)
					->with('tree',$this->tree)
					->with('taxonomy_id',$taxonomy_id); 
		if($_POST){
			$input = Input::all();
 			$rules = array(
			    'name'  => "required|max:50|taxonomy", 
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{
				$name = trim(Input::get('name'));
				$pid = trim(Input::get('pid'))?:0;
				DB::table('taxonomy') 
					->insert(array('name'=>$name,'pid'=>$pid));
				return Redirect::to_action('core/taxonomy/index',array('taxonomy_id'=>$_GET['back_taxonomy_id']))
						->with('success',__("admin.create taxonomy {:name} success",array('name'=>$name))); 
			}
		} 
 		return $views;
 	}
 	function action_edit($id){   
 		//判断权限 
 		$this->has_access("system.taxonomy.update",$id);
 		$url = action('core/taxonomy/edit/'.$id).Helper::get();
 		$first = DB::table('taxonomy')->where('id','=',$id)->first();
 		if($first->pid>0)
 			$_GET['back_taxonomy_id'] = $first->pid;
 		$taxonomy_id = $first->pid;
 		$view = 'core::taxonomy.form';  
		$views =  View::make($view)
					->with('url',$url)
					->with('tree',$this->tree)
					->with('taxonomy_id',$taxonomy_id)
					->with('first',$first); 
		if($_POST){
			$input = Input::all();
 			$rules = array(
			    'name'  => "required|max:50|taxonomy:$id", 
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{
				$name = trim(Input::get('name'));
				$pid = trim(Input::get('pid'))?:0;
				DB::table('taxonomy') 
					->where('id','=',$id)
					->update(array('name'=>$name,'pid'=>$pid));
				return Redirect::to_action('core/taxonomy/index',array('taxonomy_id'=>$_GET['back_taxonomy_id']))
						->with('success',__("admin.update taxonomy {:name} success",array('name'=>$name))); 
			}
		} 
 		return $views;
 	}
   
 	function action_del_field($id){
 		$post = DB::table('fields')->where('id','=',$id)->first();  
 		$pid = $post->pid;
 		if($_POST['delete']==1){ 
 			$this->del($id); 
 			return Redirect::to_action('core/type/fileds',array('id'=>$pid))
			   ->with('success',__("admin.delete content type #:name# success",array('name'=>$user->username))); 
 		}
 		return View::make('core::type.del_field')
 				->with('post',$post)->with('id',$id)
 				->with('pid',$pid);
 	}  
 	
 	function action_sort($id){   
 		$ids = $sort = $_POST['ids'];
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "taxonomy"; 
 		$row = DB::table($table)
 		 		->where('id','=',$id)->first();
 		foreach($ids as $k=>$id){ 
 		 	DB::table($table)
 		 		->where('id','=',$id)
 		 		->update(
 		 			array(
 		 				'sort'=>$sort[$k]
 		 			)
 		 	); 
 		}  
 		return 1;
 	}
 	
 	function action_del($id){  
 		$table = 'taxonomy';
 		$row = DB::table($table) 
 			->where('id','=',$id)
 			->first();
 	 	$dis = 1;
 	 	$f = 'success';
 	 	$msg = __("admin.action successful");
 	 	if($row->display==1){ 
 	 		$dis = 0;
 	 		$f = 'error'; 
 	 	}
 	 	DB::table($table) 
 			->where('id','=',$id)
 			->update(array(
 				'display'=>$dis
 			));
 		 
 		return Redirect::to(action('core/taxonomy/index').Helper::get())
					->with($f,$msg);
 	}
 	
 	
 	
}