<?php
/**
 * 自定义内容字段
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Type_Controller extends Core_Base_Controller {
	public $tree;
	public $spyc;
 	function init(){
 		if(Auth::user()->id!=1)
 			throw new Exception('access deny'); 
 		if(trim(gethostbyname($_SERVER['SERVER_NAME']))!='127.0.0.1') exit(__('admin.content fields just support on development environment')); 
 		$this->spyc  = new Spyc;
 		Menu::active('content type'); 
 		CMS::set('select2',true);
 		$rows = DB::table('taxonomy')->get();
 		$this->tree = TreeHelper::toTree($rows);
 	
 	}
 	function action_index(){
 		$posts = DB::table('fields')
 				->where('pid','=',0)
 				->order_by('sort','desc')
 				->order_by('id','desc')
 				->paginate(100);
 		
 		return View::make('core::type.index') 			 
 				->with('posts',$posts);
 	}
 	
 	 
 	function action_add(){
		$view = 'core::type.add';  
		$views =  View::make($view); 
		if($_POST){
			$input = Input::all();
 			$rules = array(
			    'label'  => "required|max:50",
			    'value' => 'required|match:/^[a-z][a-z_]+/|min:2|max:20|pid_value:fields',
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{
				$label = trim(Input::get('label'));
				$value = trim(Input::get('value'));
				$lock = trim(Input::get('lock'));
				$admin = trim(Input::get('admin'));
				DB::table('fields') 
					->insert(array('label'=>$label,'value'=>$value,'pid'=>0,'lock'=>$lock,'admin'=>$admin));
				return Redirect::to_action('core/type/index')
						->with('success',__("admin.create content type #:name# success",array('name'=>$label))); 
			}
		} 
 		return $views;
 		
 	}
 	
 	function action_edit($id){
		$view = 'core::type.edit'; 
		$post = DB::table('fields')->where('id','=',$id)->first();
		$views =  View::make($view)
 				->with('post',$post);
		if($_POST){
			$input = Input::all();
 			$rules = array(
			    'label'  => "required|max:50", 
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				return $views->with('validation',$validation->errors); 
			}
			else{
				$label = trim(Input::get('label'));
				$lock = trim(Input::get('lock'));
				$admin = trim(Input::get('admin'));
				DB::table('fields')
					->where('id','=',$id)
					->update(array('label'=>$label,'lock'=>$lock,'admin'=>$admin));
				return Redirect::to_action('core/type/index')
						->with('success',__("admin.update content type #:name# password success",array('name'=>$label))); 
			}
		} 
 		return $views;
 		
 	}
 	protected function _del($id){
 		DB::table('fields_validate')
	 	 ->where('field_id','=',$id)
	 	 ->delete();
		DB::table('fields_table')
	 	 ->where('field_id','=',$id)
	 	 ->delete();
 	}
 	protected function del($id,$f=true){
 		$row = DB::table('fields')->where('id','=',$id)->first();
 		$a = Node::fields_detail($row->value); 
 		$f = $a['fields'];
 		if($f){
 			if($f===true){
	 			foreach($f as $v){
	 				$ntable = "content_".$row->value."_nid";
	 				$table = "content_".$row->value."_".$v['db_type'];
	 				$sql = "SHOW TABLES LIKE '".$table."'";
	 				$exists = DB::query($sql); 
	 				if($exists)
	 					Schema::drop($table);
	 			}
	 			Schema::drop($ntable);
	 			\DB::table('node_revision')->where('fid','=',$id)->delete();
 			}
 			
 		} 
 	
 		DB::table('fields')->where('id','=',$id)->delete(); 
 		$this->_del($id); 
 		$rows = DB::table('fields')->where('pid','=',$id)->get();
 		if($rows){
 			foreach ($rows as $r) {
 				$id = $r->id;
 				$this->clear_cache($r->value);
 				$this->_del($id); 
 			}
 			DB::table('fields')->where('pid','=',$id)->delete();  
 		}
 	}
 	function action_del($id){
 		$post = DB::table('fields')->where('id','=',$id)->first();
 		if($_POST['delete']==1){
 			$this->del($id); 
 			return Redirect::to_action('core/type/index')
			   ->with('success',__("admin.delete content type #:name# success",array('name'=>$user->username))); 
 		}
 		return View::make('core::type.del')
 				->with('post',$post);
 	}
 	function action_cancel(){
 		return Redirect::to_action('core/type/index')
			   ->with('error',__("admin.delete option is canceled")); 
 	}

 	function action_fileds($id){
 		$views = View::make('core::type.field')
 				 ->with('id',$id);
 		$post = DB::table('fields')->where('id','=',$id)->first();
 		$views->with('post',$post);
 		if($post->pid==0){
 			$posts = DB::table('fields')->where('pid','=',$id)->order_by('sort','desc')->order_by('id','asc')->get();
 
 			return $views->with('posts',$posts)->with('id',$id); 
 		}

 	}
 	
 	protected function clear_cache($id){ 
 		$row = DB::table('fields')->where('id','=',$id)->first();
 		$name = $row->value;
 		$cache_id = "node_files_$name";
	 	Cache::forget($cache_id);
	 	Node::fields_detail($name);
 	}
 	protected function fields_detail($id){
 		$row = $data['row'] = DB::table('fields')->where('id','=',$id)->first(); 
 		$ne = DB::table('fields')->where('id','=',$row->pid)->first(); 
 		$data['admin'] = $ne->admin;
 		$data['db_table'] = DB::table('fields_table')
			 	 ->where('field_id','=',$id)
			 	 ->first(); 
		$data['validate'] = DB::table('fields_validate')
			 	 ->where('field_id','=',$id)->get();
		return $data;
 	}
 	/**
 	* @t 表名
 	* @name input text
 	* @len 长度
 	* @_vali 验证规则
 	*/
 	protected function create_schema($admin,$t,$field,$name,$len,$_vali){ 
 		$type = strtolower(trim(Input::get('db_type')));
 		$_t = $t;
 		$t = 'content_'.$t.'_'.$type;  
 		$t_nid = 'content_'.$_t.'_nid'; 
 		$length = \Helper::db_type($type);
 		if($length>0)
 			$type = $type."($length)"; 
 	 
 	 	$r = DB::query('SHOW TABLES');
 	 	foreach($r as $a){
 	 		foreach($a as $v){
 	 			$tb[] = $v;
 	 		}
 	 	} 
 	  
 	 	if(!in_array($t_nid,$tb)){
 	 		$uuid = "`uid` int(11) NOT NULL,";
 	 		if($admin==1){
 	 			$uuid = null;
 	 		}
 	 		$sql = "
				CREATE TABLE IF NOT EXISTS `".$t_nid."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT, 
				  `created` int(11) NOT NULL,
				  `updated` int(11) NOT NULL,
				  ".$uuid."
				  `display` tinyint(1) NOT NULL DEFAULT '1',
				  `sort` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
 	 		";
 	 		DB::query($sql);
	 	  
		}
 	 	if(!in_array($t,$tb)){
 	 		$sql = "
				CREATE TABLE IF NOT EXISTS `".$t."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `nid` int(11) NOT NULL,
				  `field_id` int(11) NOT NULL,
				  `value` $type NOT NULL, 
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
 	 		";
 	 		DB::query($sql);
	 	  
		}
	  
  	}
 	/**
 	* field_id
 	*/
 	protected function schema($id){
 		$data = $this->fields_detail($id);
 		$row =	$data['row'];
 		$db_table =	$data['db_table'];
 		$validate =	$data['validate'];  
		if($row->pid>0){
			$new =	DB::table('fields')
			 	 ->where('id','=',$row->pid)->first();
			$table = $new->value;
			$len = $db_table->value;//字段长度
			$name = $db_table->name;//字段名
			if($validate){
				foreach($validate as $v){
					$_vali[$v->name] = $v->value;
				}
			}
			 
			$field = $row->value;
			$this->create_schema($data['admin'],$table,$field,$name,$len,$_vali); 
		}
 	 
 	
		
 	}
 	function action_add_field($id){ 
 		$views = View::make('core::type.edit_field')
 				 ->with('id',$id)
 				 ->with('tree',$this->tree) 
 				 ->with('edit',false);
 		if($_POST){  
			$input = Input::all();
			$rules = array(
			    'label'  => "required|max:50", 
			    'value'  => "required|alpha|max:50|mincms_table_vali",  
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				$msg = $validation->errors;
        	 	$str = $msg->first('label',"<p>:message</p>");
        	 	$str .= $msg->first('value',"<p>:message</p>");
        	 	return $str; 
			}else{
				$label = trim(Input::get('label'));
				$value = trim(Input::get('value'));
				$tips = trim(Input::get('tips'));
				$lock = trim(Input::get('lock'));
					$row = DB::table('fields')
						  ->where('pid','=',$id)
						  ->where('value','=',$value)
						  ->first();
					if(!$row){
					 	 $new_id = DB::table('fields')
					 	 ->insert_get_id(array(
					 	 	'label'=>$label,
					 	 	'value'=>$value,
					 	 	'pid'=>$id,
					 	 	'tips'=>$tips,
					 	 	'lock'=>$lock,
					 	 ));
			 	 		 $this->field_validate_table($new_id); 
			 	 		 $this->schema($new_id);
			 	 		 $this->clear_cache($id);
					 	 \Session::flash('success',__("admin.create filed success")); 
					 	 return 1; 
					}
					return __("admin.exists filed"); 

			}
		}
		return $views; 
 	}
 	function field_validate_table($id){
 		$length = (int)trim(Input::get('length')); 
 		$db_type = strtolower(trim(Input::get('db_type')));
 		$type = Input::get('type');
 		$validation = Input::get('laravel');
		$taxonomy = Input::get('taxonomy');
		$belongs_to = Input::get('orm');   
		if($belongs_to){
			$belongs_to = serialize($belongs_to);
		}
		$plugins = Input::get('plugins'); 
		$this->spyc  = new Spyc;
   
		if($plugins){
			foreach($plugins as $k=>$v){
				if($v['more']){
					$v['more'] = $this->spyc->YAMLLoadString($v['more']);
				}
				$oo[$k] = $v;
			}
			$plugins = $oo;
		}
	 
 		$row = DB::table('fields_table')
			 	 ->where('field_id','=',$id)
			 	 ->first(); 
		$plugin = DB::table('fields_plugins')
			 	 ->where('field_id','=',$id)
			 	 ->first(); 
		if(!$plugins) $plugins = array();
		$plugins = serialize($plugins);
	
		if(!$plugin){
			if($plugins){
				DB::table('fields_plugins')->insert(
					array(
						'field_id'=>$id, 
						'options'=>$plugins,
					)
				);
			}
			
		}else{
			if($plugins){
				DB::table('fields_plugins')->where('field_id','=',$id)->update(
					array( 
						'options'=>$plugins,
					)
				);
			}
		}
		if(!$row){
			DB::table('fields_table')->insert(
				array(
					'field_id'=>$id,
					'name'=>$type,
					'length'=>$length,
					'db_type'=>$db_type,
					'taxonomy'=>$taxonomy,
					'orm'=>$belongs_to,
				)
			);
		}else{
			DB::table('fields_table')->where('field_id','=',$id)->update(
				array( 
					'name'=>$type,
					'length'=>$length,
					'db_type'=>$db_type,
					'taxonomy'=>$taxonomy,
					'orm'=>$belongs_to,
				)
			);
		}
		if($validation){
			DB::table('fields_validate')
			 	 ->where('field_id','=',$id)
			 	 ->delete();
			$num = count($validation);
			$i=1;
			foreach ($validation as $value) {
				 $i++;
				 if($i>$num) continue;
				 $a = explode(':', $value);
				 if($a[1]) $a[0] = $a[0].':';
				 DB::table('fields_validate')
				 ->insert(
					array(
						'field_id'=>$id,
						'name'=>$a[0],
						'value'=>$a[1],
					)
				);
			} 
		}
		
 	}
 	function action_edit_field($id){ 
 		$post = DB::table('fields')->where('id','=',$id)->first(); 
 		$table = DB::table('fields_table')
			 	 ->where('field_id','=',$id)
			 	 ->first(); 
		$validate = DB::table('fields_validate')
			 	 ->where('field_id','=',$id)->get();
		$plugins = DB::table('fields_plugins')
			 	 ->where('field_id','=',$id)->first();
		if($plugins){
			$plugins = unserialize($plugins->options);
		}
 		$pid = $post->pid;
 		 
 		$views = View::make('core::type.edit_field')
 				 ->with('id',$id)
 				 ->with('pid',$pid)
 				 ->with('validate',$validate)
 				 ->with('table',$table)
 				 ->with('edit',true)
 				 ->with('tree',$this->tree) 
 				 ->with('plugins',$plugins) 
 				 ->with('post',$post);
 		if($_POST){   
			$input = Input::all();
			$rules = array(
			    'label'  => "required|max:50", 
			    'value'  => "required|max:50",  
			);
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
				$msg = $validation->errors;
        	 	$str = $msg->first('label',"<p>:message</p>");
        	 	$str .= $msg->first('value',"<p>:message</p>");
        	 	return $str; 
			}else{
				$label = trim(Input::get('label'));
				$tips = trim(Input::get('tips'));
				$lock = trim(Input::get('lock')); 
			 	DB::table('fields')
			 	 ->where('id','=',$id)
			 	 ->update(array(
			 	 	'label'=>$label,
			 	 	'tips'=>$tips,
			 	 	'lock'=>$lock, 
			 	 )); 
			 	 $this->field_validate_table($id);
			 	 $this->schema($id); 
			 	 $this->clear_cache($pid);
			 	\Session::flash('success',__("admin.edit filed success"));
 				return 1;
			}
		}
		return $views; 
 	}
 	function action_del_field($id){
 		$post = DB::table('fields')->where('id','=',$id)->first();  
 		$pid = $post->pid;
 		if($_POST['delete']==1){ 
 			$this->del($id,false); 
 			return Redirect::to_action('core/type/fileds',array('id'=>$pid))
			   ->with('success',__("admin.delete content type #:name# success",array('name'=>$user->username))); 
 		}
 		return View::make('core::type.del_field')
 				->with('post',$post)->with('id',$id)
 				->with('pid',$pid);
 	}
 	
 	function action_field_sort($id){   
 		$ids = $sort = $_POST['ids'];
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "fields";
 		$fid = $id;
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
 	 
 		$this->clear_cache($id);
 		return 1;
 		
 	}
 	
 	function action_taxonomy_sort($id){   
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
 		
 	}
 	
 	function action_sort(){   
 		$ids = $sort = $_POST['ids'];
 		arsort($sort); 
 		$sort = array_merge($sort,array()); 
 		$table = "fields"; 
 		$row = DB::table($table)->where('pid','=',0)->first();
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
 	
 	function action_plugin(){
 		//Form::select('plugins',array(),null,array('style'=>'width:180px'));
 		$pls = \Helper::plugins();
 		$i = $_POST['type'];
 		$plugin = $_POST['p'];
 		$plugins = array(); 
 		$plugins = explode('::',$plugin);  
 		if(!$pls) return;
 		$select[] = __('admin.please select');
 		if($plugins){
 			foreach($plugins as $v){
 				if($v)
 					unset($pls[$v]);
 			}
 		}
 		
 		foreach($pls as $k=>$p){ 
 			if(in_array($i,$p['allow'])){
 				$out[$k] = $p;
 				$select[$k] = $k;
 			}
 		}
 		if(!$out) return;
 		$s = '<i class="icon-plus-sign-alt add-plugin hand icon-2x" style="margin-top: -4px;"></i>';
 		if($out){
 			return Form::select('plugins',$select,null,array('style'=>'width:180px')).$s;
 		} 
 	}
 	function action_plugin_config(){
 		$pls = \Helper::plugins();
 		$i = $_POST['name'];
 		$config = $pls[$i]['config'];
 		$s .="<div class='plugin  plugin_".$i."'><span class='remove-plugin icon icon-remove hand' style='float:right;'></span>";
		$s .= '<h3>'.$i.'</h3>'; 
 		foreach($config as $k=>$v){
 			$s .= __('admin.'.$k).':'.Form::text("plugins[$i][$k]");
 		}
 		$s .= __('admin.more options').':'.Form::textarea("plugins[$i][more]");
 		$s .='</div>';
 		return $s;
 	}
 	
 	function action_has(){
 		$i = $_POST['name'];
 		$posts = DB::table('fields')
 				->where('pid','=',0)
 				->order_by('sort','desc')
 				->order_by('id','desc')
 				->get();
 		$s1[] = __('admin.please select');
 		foreach($posts as $post){ 
 			$s1[$post->value] = $post->value;
 			$val = Node::fields_detail($post->value);  
 		}
 		$s2[] = __('admin.please select');
 		$form = Form::hidden('orm[type]',$i,array('type'=>'hidden'));
 		$form .= Form::select('orm[table]',$s1);
 		$form .= Form::select('orm[field]',$s2);
 		echo $form;
 		return;
 	}
 	function action_has_field(){
 		$i = $_POST['name']; 
		$val = Node::fields_detail($i); 
		$form = "<option value='id'>id</option>"; 
		foreach($val['fields'] as $k=>$v){ 
			$form .= "<option value='".$k."'>$k</option>"; 
		} 
		
 	 
 		echo $form;
 		return;
 	}
 	
 	
}