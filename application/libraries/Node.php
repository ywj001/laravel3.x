<?php
/**
 * NODE FUNCTION
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Node{ 
	 static $_obj=array();
	 static function find($name,$params=null){
	 	  return self::_load($name,$params); 
	 }
	 /**
	 * 取得一个NODE
	 */
	 static function one($name,$id){
	 	$cache_id = 'cache_node_'.$name.'_'.$id; 
	 	$cache_data = Cache::get($cache_id);
	 	if(!$cache_data){
		 	$data = Node::fields_detail($name);
			$content_type_name = $data['name'];
			$type = $data['type'];
			$fields = $data['fields']; 
			$db_types = $data['db_types'];  
		 	$node_table = 'content_'.$content_type_name.'_nid';  
			$q = DB::table($node_table.' AS n');
			if($type->admin==1)
				$get = array('n.id','n.created','n.updated','n.display','n.sort'); 
			else
		 		$get = array('n.id','n.uid','n.created','n.updated','n.display','n.sort');  
			if($db_types){  
				foreach($db_types as $nt=>$nv){    
					$t = 'content_'.$content_type_name.'_'.$nt; 
					if(!$nt) continue;
					$q = $q->left_join($t." AS $nt", "$nt.nid", '=', 'n.id');
					$q = $q->or_where("$nt.nid",'=',$id);
					//$q = $q->order_by("$nt.id",'asc');
					$get[$nt.'_id'] = "$nt.field_id AS {$nt}_id";
					$get[$nt] = "$nt.value AS {$nt}_value"; 
				}
			}
			$rows = $q->get($get);
			if(!$rows)return;
			$list = (object)array();  
			foreach($rows as $row){  
				$list->id = $row->id;
				if($type->admin!=1)
					$list->uid = $row->uid;
				$list->created = $row->created;
				$list->updated = $row->updated;
				$list->display = $row->display;
				$list->sort = $row->sort; 
				foreach($db_types as $k=>$v){
					$_id = $k.'_id';//varchar_id
					$_value = $k.'_value'; 
					foreach($v as $_k=>$_v){
						if($row->$_id && $row->$_id==$_k){
							$a_value = $row->$_value;  
							if($fields[$_v]['taxonomy']){//
								if($a_value<1) continue;
								$a_value_arr = Helper::taxonomy($a_value);
								if($a_value_arr)
								 	$_out[$_v][$a_value] = $a_value_arr;
								else
									$_out[$_v][$a_value] = $a_value;
								
						 
								$list->$_v =  array_reverse($_out[$_v],true);
							}else{
								$list->$_v =  $a_value;
							}
						 
							if($fields[$_v]['form']=='file'){
								 
								$file = DB::table('files')->where('id','=',$a_value)->get();
								if(!$file) continue;
								unset($a_value_arr);
								$a_value_arr = (object)$a_value_arr;
								foreach($file as $f){ 
									$a_value_arr->id = $f->id; 
									$a_value_arr->path = $f->path; 
									$a_value_arr->size = $f->size; 
									$a_value_arr->type = $f->type;  
								}
								$_out[$_v][$a_value] = $a_value_arr;	
								$list->$_v =  $_out[$_v];
							}
							
							
						}
					}
				}
			}
			// dump($list);exit;
			$cache_data = $list;
			Cache::forever($cache_id, $list);
		}
		return $cache_data;
	 }
	 static function find_all($name,$params=null){ 
	 	 $q = self::_load($name,$params); 
	 	 $row = $q->get(array('n.id'));   
		 if($row){
			foreach($row as $r){  
				$nid = $r->id;
				$da = self::one($name,$nid); 
				if($da)
					$nids[$r->id] = $da;
			}
		 }
		$nids = (object) $nids; 
	 	return $nids;
	 }
	 static function _load($name,$params=null){ 
		if($params && !is_array($params)){
			return self::one($name,$params);
		}	 
		$data = Node::fields_detail($name);
		$content_type_name = $data['name'];
		$type = $data['type'];
		$fields = $data['fields']; 
		$db_types = $data['db_types'];  
		self::$_obj['per_page'] = $params['per_page']?:10;
		//$order_by = array(array(array('display'=>'desc'),'sort'=>'desc'),array('id'=>'desc'));
		$order_by = array(array('sort'=>'desc'),array('id'=>'desc'));
		if($params['order_by']){
			$order_by = array_merge($order_by,$params['order_by']);
		}
		$params['order_by'] = ArrHelper::one($order_by); 
		$node_table = 'content_'.$content_type_name.'_nid';  
		$q = DB::table($node_table.' AS n');
		if($type->admin==1)
			$get = array('n.id as nid','n.created','n.updated','n.display','n.sort');
		else
			$get = array('n.id as nid','n.uid','n.created','n.updated','n.display','n.sort'); 
	 	 
		if($params['where']){ 
			$j = 0;
			foreach($params['where'] as $vo){
				$j++;
				$coloum = $vo[0];
				$li = $fields[$coloum]; 
				$d = $li['db_type'];
				if(in_array($coloum,Helper::default_columns())){
				 	 $q = $q->where("n.$coloum",$vo[1],$vo[2]);
				}else{
					$_table = 'content_'.$content_type_name.'_'.$d;
					if(!$content_type_name || !$d) continue;
					$flag = $d.$j; 
				 	$q = $q->left_join($_table." AS $flag", "$flag.nid", '=', 'n.id');
				 	$q = $q->where("$flag.field_id",'=',$li['id']);
					$q = $q->where("$flag.value",$vo[1],$vo[2]);
					self::$_obj['get'][$flag.'_id'] = "$flag.field_id AS {$d}_id";
					self::$_obj['get'][$flag] = "$d.value AS {$d}_value";  

				}
			} 
		}
		if($params['order_by']){ 
			foreach($params['order_by'] as $_key=>$_value){ 
				 if(in_array($_key,Helper::default_columns())){ 
				 	 $q = $q->order_by("n.$_key",$_value);
				 } 
			}
			 
		} 
		if($params['offset']){
			$q = $q->skip($params['offset']); 
		}
		if($params['limit']){
			$q = $q->take($params['limit']); 
		}
		 
		return $q;
	  
	 }
	 static function pager($name,$params=null){
		$q = self::_load($name,$params);    
		$posts = $q->paginate(self::$_obj['per_page'],array('n.id'));
		$row = $posts->results;
		if($row){ 
			foreach($row as $r){
				$da = self::one($name,$r->id);
				if($da)
					$nids[$r->id] = $da;
			}
		 }
		$nids = (object) $nids; 
		$posts->results = $nids;
		return $posts;	 	
	 }
	 static function save($name,$input,$uid=0){
	 	 $input = (array)$input;
	 	 //当字段为数组时 使数组不重复
	 	 foreach($input as $k=>$in){
			if(is_array($in)){
				$in = array_unique($in);
			}
			$new_input[$k] = $in;
			$input = $new_input;
		}
	 	 if($input['id']){
	 	 	 $nid = decode($input['id']);
	 	 	 \Session::flash('nid',$nid);
	 	 	 unset($input['_id']);
	 	 }    
	 	 $test = $input;
	 	 unset($test['id']); 
	 	 if(\CMS::array_len($test)<1) return;
	 	 $data = Node::fields_detail($name);
 		 $type = $data['type'];
 		 $fields = $data['fields']; 
	 	 $node_table = 'content_'.$type->value.'_nid';  
	 	 if(!$nid){ 
	 	 	 if($uid>0){
	 	 	 		$default_data = array(
				 	 	'created'=>time(),
				 	 	'updated'=>time(),
				 	 	'uid'=>$uid,
				 	 );
			}else{
				$default_data = array(
				 	 	'created'=>time(),
				 	 	'updated'=>time(), 
				 	 );
			}
		 	 $nid = DB::table($node_table)
				 	 ->insert_get_id($default_data); 
		     DB::table($node_table)
					->where('id','=',$nid) 
				 	->update(array( 
				 	 	'sort'=>$nid
			 	 )); 
		 }else{
		 	DB::table($node_table)
					->where('id','=',$nid) 
				 	->update(array( 
				 	 	'updated'=>time()
			 	 )); 
		 }
	 	 foreach($fields as $f){
	 	 	$f = (object)$f;
	 	 	//取得字段表名 nid field_id value sort
	 	 	$table = 'content_'.$type->value.'_'.$f->db_type; 
			$one = DB::table($table)
		 	 	->where('nid','=',$nid)
		 	 	->where('field_id','=',$f->id)
		 		->first();	
		 	$input_value = $input[$f->value];   
		 	if(!$input_value) continue;
			if($one){
				if(!is_array($input_value)){ 
					DB::table($table)
						->where('nid','=',$nid)
			 	 		->where('field_id','=',$f->id)
					 	->update(array( 
					 	 	'value'=>$input_value,
				 	 )); 
			 	} 
			}else{
				if(!is_array($input_value)){
					DB::table($table)
					 	 ->insert_get_id(array(
					 		'nid'=>$nid,
					 	 	'field_id'=>$f->id, 
					 	 	'value'=>$input_value,
				 	 )); 
			 	} 
			} 
			if(is_array($input_value)){ 
				$input_value = array_reverse($input_value,true);
				DB::table($table)
					 	 ->where('nid','=',$nid)
			 	 		 ->where('field_id','=',$f->id)
			 			 ->delete(); 
				foreach($input_value as $invalue){ 
			 		DB::table($table)
					 	 ->insert_get_id(array(
					 		'nid'=>$nid,
					 	 	'field_id'=>$f->id, 
					 	 	'value'=>$invalue,
				 	 )); 
				}
			}
		 
	 	 }  
	 	 $cache_id = 'cache_node_'.$name.'_'.$nid; 
	 	 $cache_data = Cache::forget($cache_id);
	 	 return $nid;
	 }
	 
	 static function fields_rules($name){
	 	$data = static::fields_detail($name);
	 	$fields = $data['fields'];
	 	$rules = \CMS::node_rules($name,$fields);
	 	return $rules;
	 }
	 static function orm($orm){
	 	$name = $orm['table'];
	 	$field = $orm['field']; 
	 	$rows = node($name);  
	 	$out[] = __('admin.please select');
	 	foreach($rows as $row){
	 		$out[$row->id] = $row->$field;
	 	}
	 	if(!$out) return array();
	  
	 	return $out;
	 }
	 static function fields_detail($name){
	 	 $cache_id = "node_files_$name";
	 	 $cache_data = Cache::get($cache_id);
	 	 if(!$cache_data){
	 		$row = DB::table('fields')->where('value','=',$name)
	 			->where('pid','=',0)->first();
	 		$fields = DB::table('fields AS a')->where('pid','=',$row->id)
	 				->left_join('fields_table AS t', 'a.id', '=', 't.field_id')
	 				->left_join('fields_validate AS v','a.id', '=', 'v.field_id')
	 				->left_join('fields_plugins AS p','a.id', '=', 'p.field_id')
	 				->order_by('a.sort','desc')
	 				->order_by('a.id','asc')
	 				->get(array(
	 					'a.id', 
	 					'a.label', 
	 					'a.tips',
	 					'a.value', 
	 					'a.lock', 
	 					't.orm',
	 					'p.options as plugin', 
	 					't.name as cname', 
	 					't.db_type', 
	 					't.length', 
	 					't.taxonomy', 
	 					'v.name as vname', 
	 					'v.value as vvalue'
	 				)); 
	 
	 		foreach($fields as $f){  
	 			$out[$f->value]['id'] = $f->id;
	 			$out[$f->value]['label'] = $f->label;
	 			$out[$f->value]['value'] = $f->value;
	 			if($f->plugin){
	 				$plugin = unserialize($f->plugin);
	 				$out[$f->value]['plugins'] = $plugin;
	 			}
	 			$out[$f->value]['form'] = $f->cname;
	 			if($f->orm){
	 				$orm = unserialize($f->orm);
	 				$out[$f->value]['form'] = array('select'=>$orm);
	 			}
	 			$out[$f->value]['orm'] = $orm;
	 			
	 			
	 			$out[$f->value]['db_type'] = $f->db_type;
	 			$out[$f->value]['tips'] = $f->tips;
	 			$out[$f->value]['lock'] = $f->lock; 
	 		 	$db_types[$f->db_type][$f->id] = $f->value;
	 			$out[$f->value]['limit'] = $f->length;
	 			if($f->taxonomy>0)
	 				$out[$f->value]['taxonomy'] = $f->taxonomy; 
	 			if($f->vname)
	 				$out[$f->value]['validate'][] = $f->vname.$f->vvalue;	
	 				
	 		}  
			$cache_data = array('type'=>$row,'fields'=>$out,'db_types'=>$db_types,'name'=>$row->value);
			Cache::forever($cache_id, $cache_data);
		}
		return $cache_data;
 	}
 	
 	static function hook($name,$field,$value=null){
		$name = strtolower($name);
		$dir = path('app')."hooks/{$name}.php";
		$class = "Hooks\\".ucfirst($name);   
		if(!method_exists($class,$field)) return;
		return call_user_func($class."::$field",$value); 
	}
	static function hook_way($name,$field='before_validte',$row=null){
		$name = strtolower($name);
		$dir = path('app')."hooks/{$name}.php";
		$class = "Hooks\\".ucfirst($name);   
		if(!method_exists($class,$field)) return;
		return call_user_func($class."::$field",$row); 
	}
	static function node_revision($fid,$nid,$input){ 
		$uid = \Auth::user()->id; 
		if($input['id']){
	 	 	 unset($input['id']);
	 	}
	 	if(!$nid) return;
	 	$input = serialize($input);
	 	$uni = md5($input);
	 	$row = \DB::table('node_revision')
	 		->where('nid','=',$nid)
	 		->where('uni','=',$uni)
	 		->where('fid','=',$fid)->first();
	 	if(!$row){
			\DB::table('node_revision')
	 	 		->insert(array('body'=>$input,'created'=>time(),'nid'=>$nid,'fid'=>$fid,'uid'=>$uid,'uni'=>$uni));  
	 	}
	 	
	}
	static function get_node_revision($fid,$nid,$vid=0){ 
		if(\Auth::user()->id!=1){
			$access = Cache::get('auth_access_lists');   
			if($access["_mincms_only.self.update"] || $access["_mincms_only.self.update"]){
				$uid = 	Auth::user()->id;
			}
		}
		//取得当前revision
		if($vid>0){
			$row = \DB::table('node_revision')->where('id','=',$vid)->first();
			if(!$row) return;
			$row->body = (object)unserialize($row->body);
			if($uid && $row->uid!=$uid){
				return false;
			}
			return $row;
		}
		
		$query = \DB::table('node_revision')
	 		->where('nid','=',$nid)
	 		->where('fid','=',$fid)
	 		->order_by('id','desc');
	 	if($uid){
	 		$query = $query->where('uid','=',$uid);
	 	}
	 	$rows = $query->get();
		return $rows;
	}
	 
	

  
}