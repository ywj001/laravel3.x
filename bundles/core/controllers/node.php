<?php
/**
 * NODE
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Node_Controller extends Core_Base_Controller {
 	function init(){
 		Menu::active(array('content'));   
 	}
 	function access($data){
 		$t = $data['type'];
 		if($t->lock==1){
	 		if(Auth::user()->id!=1){
	 			exit('access deny');
	 		}
 		}
 	}
 	
 	function action_index($name){  
 		//判断权限
 		$this->has_access("node.$name.index");
 		Menu::active(array('content',$name));   
 		$data = Node::fields_detail($name);
 		$this->access($data);
 		$type = $data['type'];  
 		$fields = $data['fields'];
 		if(!$fields){
 			return Redirect::to(action('core/home/index'))
					->with('error',__('admin.no fileds'));
 		}
 		$posts = Node::pager($name,array('per_page'=>50));  
 		$total = $posts->total;
 		if($total>0){
 			$total = ' ('.__('admin.total results').' <span class="text-success">'. $total.'</span> )';
 		}else{
 			$total = ' ( <span class="text-error">'.__('admin.no results').'</span> )';
 		}
 		CMS::set('navigation',$type->label.' '.$name .$total);
 		if(Auth::user()->id!=1){
 			CMS::set('navigation',$type->label .$total);
 		}
 		$row = DB::table('views')
 			->where('display','=',0)
 			->where('value','=',$name)
 			->first();
 		$coloums = unserialize($row->memo);
 		return View::make('core::node.index')
 				->with('name',$name)
 				->with('type',$type)
 				->with('posts',$posts)
 				->with('coloums',$coloums)
 				->with('fields',$fields);
 	}
 	
 	function validate_ignor($v){
 		if($v){
 			foreach($v as $vo){
	 		  if(strpos($vo,'mimes')===false){
	 		  		$va[] = $vo;
	 		  }
	 		}
 		}
 		return $va;
 	}
 	function action_add($name){  
 		Menu::active(array('content',$name));
 		//判断权限
 		$this->has_access("node.$name.create");
 		$data = Node::fields_detail($name);
 		$this->access($data);
 		$type = $data['type'];  
 		$type_id = $type->id;
 	 
 		$fields = $data['fields']; 
 		if(Auth::user()->id==1)
 			CMS::set('navigation',$type->label.' '.$name);
 		else
 			CMS::set('navigation',$type->label);
 		if($_POST){ 
 			foreach($fields as $f){ 
 			 	$f = (object)$f;
 			 	$f->validate= $this->validate_ignor($f->validate); 
 				if($f->validate){ 
 					$dd = $f->db_type;//
 					$table = "content_{$name}_$dd"; 
 					$r = implode('|',$f->validate); 
 					if(strpos($r,'node_unique')!==false){
 						$fid = $f->id;
 						$r = str_replace('node_unique',"node_unique:$table,$fid",$r);
 					} 
 					$rules[$f->value] = $r;
 				}
 			}     
 			$input = Input::all();    
 			if(Node::hook_way($name,'before_validte',$rules)){
 				$rules = Node::hook_way($name,'before_validte',$rules);
 			}
 			if($rules) 
				$validation = Validator::make($input, $rules);
			
			if ($rules && $validation->fails())
			{
				$msg = $validation->errors;
				foreach($fields as $f){  
					$f = (object)$f;
	        	 	$str .= $msg->first($f->value,"<p>:message</p>"); 
        	 	}
        	 	return $str; 
			}else{ 
				if($type->admin!=1) $myuid = \Auth::user()->id;
				$nid = Node::save($type->value,$input,$myuid);
				Node::hook_way($name,'save',$nid);
				//保存多个版本   
				Node::node_revision($type_id,$nid,$input);
				\Session::flash('success',__("admin.save node success")); 
				return 1; 
			} 
 		} 
 		return View::make('core::node.form')
 				->with('name',$name)
 				->with('type',$type) 
 				->with('fields',$fields);
 	}
 	
 	function action_edit($id,$name){  
 		Menu::active(array('content',$name));
 		//判断权限
 		$one = Node::find($name,$id);   
 		
 		$this->has_access("node.$name.update",$one->uid);
 		$data = Node::fields_detail($name);
 	 
 		$ff =$data['type'];
 		$type_id = $ff->id;
 	 	$vid = $_GET['revision'];
 		if($vid>0){
 			$revision = Node::get_node_revision($type_id,$id,$vid); 
 			if($revision->body)
 				$one = $revision->body;  
 		}
 		$this->access($data);
 		$type = $data['type'];
 		$fields = $data['fields'];  
 		if(Auth::user()->id==1)
 			CMS::set('navigation',$type->label.' '.$name);
 		else
 			CMS::set('navigation',$type->label);
 		//对有插件的字段值进行转换
 		foreach($fields as $f){ 
		 	$f = (object)$f; 
		 	$new_key = $f->value;
			if($f->validate){  
				$r = implode('|',$f->validate);  
				if(strpos($r,'numeric')!==false && $f->plugins){ 
					foreach($f->plugins as $k=>$v){
						$new_value = plugin($k,$one->$new_key,'Node','select');
						if($new_value)
							$one->$new_key = $new_value;
					}   
				}  
			}
		}   
 		if($_POST){
 			$input = Input::all();   
 			foreach($fields as $f){ 
 			 	$f = (object)$f;
 			 	$f->validate= $this->validate_ignor($f->validate); 
 				if($f->validate){ 
 					$dd = $f->db_type;//
 					$table = "content_{$name}_$dd"; 
 					$r = implode('|',$f->validate); 
 					if(strpos($r,'node_unique')!==false){
 						$fid = $f->id;
 						$r = str_replace('node_unique',"node_unique:$table,$fid,$id",$r);
 					}
 					if(strpos($r,'numeric')!==false && $f->plugins && !empty($_POST[$f->value]) ){ 
 						foreach($f->plugins as $k=>$v){
 							$input[$f->value] = plugin($k,trim($_POST[$f->value]),'Node','insert');
 						}  
 						if($input[$f->value]){   
 							Request::foundation()->request->replace($input);
 						} 
 					} 
 					$rules[$f->value] = $r;
 				}
 			}  
 			
 			$input = Input::all();  
 		 
 			if(Node::hook_way($name,'before_validte',$rules)){
 				$rules = Node::hook_way($name,'before_validte',$rules);
 			}
 		 
 			if($rules) 
				$validation = Validator::make($input, $rules);
		 
			if ($rules && $validation->fails())
			{
				$msg = $validation->errors;
				foreach($fields as $f){  
					$f = (object)$f;
	        	 	$str .= $msg->first($f->value,"<p>:message</p>"); 
        	 	}
        	 	return $str; 
			}else{
				if($type->admin!=1) $myuid = \Auth::user()->id;
					$nid = Node::save($type->value,$input,$myuid); 
				Node::hook_way($name,'save',$nid);
				//保存多个版本 
				Node::node_revision($type_id,$nid,$input);
				if(\Session::has('nid'))
					\Session::flash('success',__("admin.update node success")); 
				else
					\Session::flash('success',__("admin.create node success")); 
				return 1; 
			} 
 		} 
 	 
 		return View::make('core::node.form')
 				->with('name',$name)
 				->with('type',$type) 
 				->with('one',$one) 
 				->with('vid',$vid)  
 				->with('type_id',$type_id)
 				->with('nid',$id)    
 				->with('fields',$fields);
 	}
 	
 	
 	function action_set($name,$field){ 
 		$row = DB::table('views')
 			->where('display','=',0)
 			->where('value','=',$name)
 			->first();
 		if(!$row){
 			DB::table('views')->insert(
 				array(
 					'value'=>$name,
 					'memo'=>serialize(array(
 						$field=>1
 					)),
 					'display'=>0,
 				)
 			);
 		}else{
 			$data = unserialize($row->memo);
 			if(is_array($data) && array_key_exists($field,$data)){
 				unset($data[$field]);
 			}else
 				$data[$field] = true; 
 		 
 			$data = serialize($data);
 			DB::table('views')
 				->where('display','=',0)
 				->where('value','=',$name)
 				->update(
 				array(
 					'value'=>$name,
 					'memo'=>$data,
 					'display'=>0,
 				)
 			);
 		}
		return Redirect::to(action('core/node/index',array('name'=>$name)))
					->with('success',__("admin.set display field success"));  
 	}
 	
 	function action_del($id,$name){ 
 		//判断权限
 		$one = Node::find($name,$id);    
 		$this->has_access("node.$name.delete",$one->uid);
 		   
 		$data = Node::fields_detail($name);
 		$this->access($data);
 		$cache_id = 'cache_node_'.$name.'_'.$id;
 		$table = 'content_'.$name.'_nid';
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
 		Cache::forever($cache_id, $list);
 		return Redirect::to(action('core/node/index',array('name'=>$name)).Helper::get())
					->with($f,$msg);
 	}
 	function action_revision(){
 		$fid = (int)$_POST['fid'];
 		$nid = (int)$_POST['nid'];
 		if(!$nid) return 1;
 		$rows = Node::get_node_revision($fid,$nid);
 		if(!$rows) return 1;
 		$nums = count($rows);
 		$html = '<ul class="revision">
 		<li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">'.__('admin.revision').' <b class="caret"></b></a>
          <ul class="dropdown-menu">';
        $users  = Cache::get('users');
        
 		foreach($rows as $row){
 			$i = $nums--;
 			$row->body = (object)unserialize($row->body);
 			$u = $users[$row->uid];
 			$html .="<li><a href='".Helper::get_url(array('revision'=>$row->id,'_revision'=>base64_encode($i)))."'> <span class='label label-info'>".$i.'</span>   ['.$u->username."  ".date('Y-m-d H:i',$row->created)."]</a></li>";
 			
 		}
 		$html .= "</ul></li></ul>";
 		return $html;
 	}
 	function action_sort($name){  
 		$cache_id = 'cache_node_'.$name.'_';
 		$ids = $sort = $_POST['id']; 
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "content_{$name}_nid";  
 		foreach($ids as $k=>$id){
 			$cache_id = $cache_id.$id;
 			Cache::forget($cache_id); 
 		 	DB::table($table)->where('id','=',$id)
 		 		->update(
 		 			array(
 		 				'sort'=>$sort[$k]
 		 			)
 		 	); 
 		}
 		return 1;
 	}
 	
 	

}