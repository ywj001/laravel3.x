<?php
/**
 * Helper
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Helper{
	 static function form($orm,$key,$value){
	 	if(!is_array($orm)) return;
	 		$rows = node('oauth'); 
	 	return Form::select($key,Node::orm($orm['select']),$value,array('style'=>'width:200px;'));
	 }
	 static function ajax($id,$url,$data=null){
	 	if($data){
		 	$data = JS::encode($data);
			if($data)
				$out = $data.',';
		}
		$n = 'ajax_page_'.md5($id.$url.$out);
		CMS::script($n,"
		function ajax_node_".$id."(data){
			$('#".$id."').html(data);
			$('#".$id." .pagination a').click(function(){ 
				if($(this).attr('href')=='#') return false;
				$.post($(this).attr('href'),".$out." function(data){
					ajax_node_".$id."(data);
				});
				return false;
			}); 
		}
		ajax_load_".$id."();
		function ajax_load_".$id."(){
			$.post('".$url."',".$out."function(data){
				 ajax_node_".$id."(data);	 					 
			});
		}
		");	
	 }
	 static function theme_language($name='theme',$get='theme',$is_admin=false){
	 	$key = $get;
		if(true===$is_admin){ 
			$uid = Auth::user()->id;
		 	$name = $name.'_'.$uid;
		}
	 	if($_GET[$get]){
	   		Cookie::forever($name,$_GET[$get]);
	   		$theme = $_GET[$get];
	   		//为后台管理员时更新数据库 
		    if(true===$is_admin){ 
		   		Helper::update_profile(array($key=>$theme),$key);
		    }
	    }else{
	   		if(Cookie::get($name))
	   			$theme = Cookie::get($name);
	   		elseif($uid){ 
				$u = \DB::table('users')->where('id','=',$uid)->first();
				$m = unserialize($u->memo);
				$theme = $m[$key];
				Cookie::forever($name,$theme);
	   		}
	    } 
	    return $theme;
	 }
 	 static function update_profile($memo,$name){ 
		$id = Auth::user()->id;
		$u = \DB::table('users')->where('id','=',$id)->first();
		$m = unserialize($u->memo);
		if($m){
			$memo = array_merge($m,$memo);
			 
		} 
		$arr = $memo;
		$memo = serialize($memo);
		\DB::table('users')->where('id','=',$id)->update(array('memo'=>$memo));
		 
		 
	 }
	 static function cck_value($values){
	 	$num = count($values);
	 	$i=0;
	 	foreach($values as $value) {
		 	if(is_object($value)){
		 		if($value->id && $value->path){
		 			if($i++<2)
		 				$out .= self::file_show($value); 
		 			if($i>2)
		 				$ext = '...';
		 		}else{
		 			if($i>2)
		 				$ext = '...';
		 		}
		 	}
		 	else{
		 		if($i++<2)
		 			$out .= $value .' ';
		 		if($i>2)
		 			$ext = '...';
		 	}
		 }
	 	return $out.$ext;
	 }
	 static function file_show($file){
	 	if(strpos($file->type,'image')!==false){
			$tag = "<a href=".URL::base().'/'.$file->path." rel='lightbox[]'>".HTML::image(imagecache($file->path,1)).'</a>';
		}
		return $tag;
	 }
	 static function cck_files($files,$field){
	 	 if(!$files)return;
	 	 
	 	 foreach($files as $f){ 
		 	$tag .= "<div class='file'><span class='icon-remove hand'></span><input type='hidden' name='".$field."[]' value='".$f->id."' >";
			$flag = false;
			if(strpos($f->type,'image')!==false){
				$flag = true;
				$tag .= "<a href=".URL::base().'/'.$f->path." rel='lightbox[]'>".HTML::image(imagecache($f->path,1)).'</a>';
			} 
			else if(in_array(ext($f->path),array('flv','mp4','avi','rmvb','webm'))){
				$flag = true;
				$tag .= "<img src='".URL::base().'/misc/icon/video.png'."' />";
			}
			
			switch (ext($f->path)) {
				case 'zip': 
					$tag .= "<img src='".URL::base().'/misc/icon/zip.png'."' />";
					break;
				case 'txt': 
					$tag .= "<img src='".URL::base().'/misc/icon/txt.png'."' />";
					break;
				case 'pdf': 
					$tag .= "<img src='".URL::base().'/misc/icon/pdf.png'."' />";
					break;
				case 'doc': 
					$tag .= "<img src='".URL::base().'/misc/icon/word.png'."' />";
					break;
				default:
					if(false === $flag)
						$tag .= "<img src='".URL::base().'/misc/icon/none.png'."' />";
					break;

			} 
			$tag .="</div>"; 
 		}
 		return $tag;
	 }
	 
	 static function taxonomy($id){
	 	$row = DB::table('taxonomy')->where('id','=',$id)->first(); 
	 	if(!$row) return ;
 		return $row->name;
	 }
	 static function taxonomy_node_form($id){
	 	$rows = DB::table('taxonomy')->get(); 
	 	if(!$rows) return array();
 		return TreeHelper::toTree($rows,$id);
	 }
	 static function taxonomy_items($id){
	 	return  DB::table('taxonomy')
 				->where('pid','=',$id)->order_by('sort','desc')->get();
 		 
	 }
	 static function taxonomy_has_item($id){
	 	$row = self::taxonomy_items($id);
 		if($row) return true;
 		return false;
	 }
	 static function default_columns(){
	 	return array('id','created','uid','updated','display','sort');
	 }
	 static function get($out=null){
	 	if($out) unset($_GET[$out]);
	 	
	 	foreach($_GET as $k=>$v){
	 		$s .=$k.'='.$v.'&';
	 	}
	 	if($s){
	 		return '?'.substr($s,0,-1);
	 	}
	 	return;
	 } 
	 static function get_url($params){
	 	$url = URI::current(); 
	 	if($_GET){
	 		$params = array_merge($_GET,$params); 
	 	} 
	 	foreach($params as $k=>$v){ 
	 		$s .=$k.'='.$v.'&';
	 	}
	 	if($s){
	 		return '?'.substr($s,0,-1);
	 	}
	 	return;
	 }
	 static function db_type($name=null){
	 	 $data = array( 
			 	 'VARCHAR'=>255, 
			 	 'TEXT'=>null,
			 	 'TINYINT'=>3,
			 	 'INT'=>11, 
			 	 'BIGINT'=>20,
			 	 'FLOAT'=>.2
		 );
	 	 if(!$name)return $data;
	 	 return $data[strtoupper($name)]; 
		 
	 
	 }
 	 static function cck(){ 
 	 	$a = array(
 	 		'text', 
 	 		'textarea', 
 	 		'file', 
 	 		'select',
 	 		'belongs_to',
 	 		'checkbox',
 	 		'radiobox', 
 	 		
 	 	);
 	 	foreach ($a as  $value) {
 	 		$out[trim($value)] = trim($value); 
 	 	}
 	 	return $out;
 	 }
 	 static function validation(){ 
 	 	$a = array(
 	 		'required', 
 	 		'node_unique',
 	 		//'required_with:', 
 	 		'alpha', 'alpha_num', 'alpha_dash',
 	 		'size:','between:','min:','max:','numeric','integer',
 	 		'in:','not_in:',
 	 	//	'accepted',
 	 		//'same:',
 	 		//'different:',
 	 		'match:',
 	 		
 	 		//'exists:','after:',
 	 		'email',
 	 		'url',//'active_url',
 	 		'mimes:',
 	 		//'image',
 	 	);
 	 	foreach ($a as  $value) {
 	 		$out[trim($value)] = __('admin.'.trim($value));
 	 	}
 	 	return $out;
 	 }
 	 
 	 static function ui_sort($id,$url){
 	 	 assets('misc/jui/jquery-ui.js'); 
   		 assets("misc/jui/css/flick/jquery-ui.min.css");
 	 	 CMS::script(
			'hepler_ui_sort'.$id, 
		 	 	"
		 	 //	$( '".$id." tbody td' ).addClass('hand');
				var   node_form_sort;
				var fixHelper = function(e, ui) {
			        ui.children().each(function() {
			            $(this).width($(this).width());                  
			        });
			        return ui;
			    };
		 	 	$( '".$id." tbody' ).sortable({
				helper: fixHelper,
				start:function(e, ui){  
					node_form_sort=$('".$id."').serialize();
		            ui.helper.addClass('highlight');
		            ui.helper.find('td').css({'width':ui.helper.find('td').attr('width')});  
		            return ui;  
		        },  
		        stop:function(e, ui){   
		           ui.item.removeClass('highlight');  
		           if($('".$id."').serialize() == node_form_sort ) return false; 
		           $.post('".$url."',  $('".$id."').serialize(),function(data) {
					  if(data==1) noty({text:'".__('admin.sort success')."',type:'success',timeout:1000});
					});
		           return ui;  
		        }  	
			}).sortable('serialize'); ");
 	 }
 	 
 	 static function plugins(){
		$dir = path('public').'plugins';
		$list = scandir($dir);
		foreach($list as $vo){   
			if($vo !="."&& $vo !=".." && $vo !=".svn" )
			{
				if(!file_exists($dir."/$vo/node.php")) continue;
				$class = "Plugins\\".ucfirst($vo)."\Node";   
				$out[$vo]['config'] = call_user_func($class.'::config',$params);
				$out[$vo]['allow'] = call_user_func($class.'::allow',$params);
			}
		} 
		return $out;
		
 	 }
}