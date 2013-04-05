<?php
/**
 *  
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
 /**
 * 
 * /imagecache?id=uploads/1_imagecache1.jpg
 
	RewriteCond %{REQUEST_FILENAME} !\.(jpg|jpeg|png|gif)$ 
	RewriteRule uploads/imagecache/(.*)$ /imagecache?id=uploads/$1 [NC,R,L]  
	
 */
class Core_Imagecache_Controller extends  Base_Controller {
 	public $water_path = "uploads/watermark/";
	function init(){ 
		//判断权限
 		$this->has_access("system.imagecache");
 		Menu::active(array('imagecache'));  
 	}
 	function data($id){
 		$cache_id = 'imagecache_data_'.$id;
	 	$data = Cache::get($cache_id);
	 	if(!$data){
	 		$data = \DB::table('imagecache')->where('id','=',$id)->first();
	 		Cache::forever($cache_id, $data);
	 	}
	 	return $data;
 	}
	function action_admin($id=0){  
		Menu::active(array('imagecache','system'));  
		CMS::auth();//判断权限 
		if($id>0){
			$post = $this->data($id);
			$memo = unserialize($post->memo);
		} 
		if($_POST){	 
			
			$input = Input::get();
			$p = serialize($input['params']);
		
			if(!$input['id']){ 
				$id = \DB::table('imagecache')
					->insert_get_id (array(
						'name'=>$input['name'],
						'memo'=>$p
					));
				
			}else{	 
				\DB::table('imagecache')->where('id','=',$id)
					->update(array(
						'name'=>$input['name'],
						'memo'=>$p
					));
			}
			$cache_id = 'imagecache_data_'.$id;
			Cache::forget($cache_id);
			return Redirect::to_action('core/imagecache/admin') 
						->with('success',__("admin.success")); 
		 
		}
		 
		$list = array(
			'bgcolor'=>'bgcolor',
			'quality'=>'quality', 
			'crop_resize'=>'crop_resize',
			'resize'=>'resize', 
			'crop'=>'crop',
			'rotate'=>'rotate',
			'watermark'=>'watermark',
			'border'=>'border',
			'rounded'=>'rounded',
		);
		
		if($memo){ 
			foreach($memo as $k=>$v)
				unset($list[$k]);
		}
		$posts = DB::table('imagecache')->order_by('id','desc')->paginate(10); 
		return View::make('core::imagecache.admin') 
				->with('list',$list)
				->with('id',$id)
				->with('post',$post)
				->with('water_path',$this->water_path)
				->with('posts',$posts);
	}
	function action_ajax(){
		CMS::auth();//判断权限 
		$id = $_POST['id'];
		$fid = $_POST['fid'];
		if($id>0){
			$post = $this->data($id);
			$ops = unserialize($post->memo);
		}
		$str = "<div class='water_form'> 
			<h3 class=' title hand' style='float: left;width: 100px;' >".__("admin.$fid")."</h3>  
			<span class='icon-remove hand' style='float: left;line-height: 40px;'></span>
			<div class='new' style='clear:both;'>
			";
		switch($fid){
			case 'bgcolor':
				$val = $ops['bgcolor']?:'#00000';
				$str .= "<input type='text' value='".$val."' name='params[bgcolor]' id='bgcolor'>
			<div id='farbtastic'></div>"; 
				break;
			case 'quality':
				$val = $ops['quality']?:'75';
				$str .= "<input type='text' value='".$val."' name='params[quality]' id='quality'>
			<div rel='quality'></div>"; 
				break;
			case "resize":
				$width = $ops['resize']['width']?:'75';
				$height = $ops['resize']['height']?:'75';
				$checkbox = $ops['resize']['checkbox'];	
				if($checkbox==1)
					$checked = "checked='checked'";
				$str .= __('admin.width')."<input type='text' value='".$width."' name='params[resize][width]'>"; 
				$str .= __('admin.height')."<input type='text' value='".$height."' name='params[resize][height]'>"; 
				$str .= __('admin.fixed size')."<input ".$checked." type='checkbox' value=1 name='params[resize][checkbox]'>"; 
			 
				break;
			case "crop_resize":
				$width = $ops['crop_resize']['width']?:'75';
				$height = $ops['crop_resize']['height']?:'75'; 
				$str .= __('admin.width')."<input type='text' value='".$width."' name='params[crop_resize][width]'>"; 
				$str .= __('admin.height')."<input type='text' value='".$height."' name='params[crop_resize][height]'>";  
				break;	 
			case 'crop':
				$x1 = $ops['crop']['x1']?:20;
				$y1 = $ops['crop']['y1']?:20;
				$x2 = $ops['crop']['x2']?:100;	
				$y2 = $ops['crop']['y2']?:100;	 
				$str .= __('admin.x1')."<input type='text' value='".$x1."' name='params[crop][x1]'>"; 
				$str .= __('admin.y1')."<input type='text' value='".$y1."' name='params[crop][y1]'>"; 
			 	$str .= __('admin.x2')."<input type='text' value='".$x2."' name='params[crop][x2]'>"; 
				$str .= __('admin.y2')."<input type='text' value='".$y2."' name='params[crop][y2]'>";
				break;
			case 'rotate':
				$rotate = $ops['rotate']?:90;
				$str .= __('admin.rotate')."<input type='text' value='".$rotate."' name='params[rotate]'>"; 
				break;
				
			case 'border':
				$border_a = $ops['border']['border']?:2;
				$border_color = $ops['border']['color']?:"#000000";
				$str .= __('admin.width')."<input type='text' value='".$border_a."' name='params[border][border]'>"; 
				$str .= __('admin.color')."<input type='text' id='border_color' value='".$border_color."' name='params[border][color]'>
				<div id='farbtastic_border_color'></div>
				"; 
				break;
			case 'rounded':
				$rounded = $ops['rounded']?:10;
				$str .= "<input type='text' value='".$rounded."' name='params[rounded]'>"; 
				break;
			case 'watermark': 
				$path = $this->water_path;
				$list = DirHelper::listFile(path('public').$path);
				if(!$list['dir']) continue;
				$fs = str_replace(path('public').$path,'',$list['dir']);
				if($fs){
					foreach($fs as $f){
						if(in_array(ext($f),array('jpg','jpeg','png','gif','bmp')))
							$fsn[$f]=$f;
					}
				} 
				if(!$fsn) $fsn=array();
				$file = $ops['watermark']['file'];
				$position = $ops['watermark']['position'];
				$padding = $ops['watermark']['padding']; 
				$str .= __('admin.file').Form::select('params[watermark][file]',$fsn,$file,array('id'=>'watermark_file')); 
				$str .=__('admin.position').'<br>';
			 	for($i=1;$i<10;$i++){
			 		unset($ck);
			 		if($position==$i)
			 			$ck = "checked='checked'";
					$str .= "<input type='radio' value='".$i."' $ck class='radio_position' name='params[watermark][position]'>"; 
					if($i%3==0)
						$str .='<br>';
				}
				$str .=__('admin.padding'). "<input type='text' value='".$padding."' name='params[watermark][padding]'>"; 
				if($file) $img = HTML::image(URL::base().'/'.$path.$file);
				$str .=__('admin.watermark'). "<div id='watermark_show'>$img</div>"; 
				break;
		 
		}
		$str .=" </div></div>";
		return $str;
	}
  
  	public function action_index()
	{ 
	 	require_once __DIR__.'/../libraries/Image_Driver.php';
	 	require_once __DIR__.'/../libraries/Image_Gd.php';
	 	require_once __DIR__.'/../libraries/Image_Imagemagick.php';
	 	require_once __DIR__.'/../libraries/Image_Imagick.php';
	 	require_once __DIR__.'/../libraries/FuelImage.php';  
		ini_set("gd.jpeg_ignore_warning", 1);
		$old_id = $id = $_GET['id'];   
		$name = substr($id,strrpos($id,'/')+1);
		$c = substr($name,strrpos($name,'imagecache'));
		$ext = ext($id);  
		$id = str_replace('_'.$c,'',$id).'.'.$ext; 
		$imagecache_id = (int)str_replace('imagecache','',$c);
		$n = substr($id,strrpos($id,'/'));
		$original_file = path('public').$id;
	 	$old_id = str_replace('uploads/','',$old_id);
		//系统内部已设置的图片效果
		if(!$imagecache_id || !file_exists($original_file) || getimagesize($original_file)==false) { 
			return \URL::base().'uploads/'.$id;
		} 
		
	 	$new =  path('public').'uploads/imagecache/'.$old_id;//新图片名     
	    $dir = DirHelper::dir($new);   
		if(!is_dir($dir)) DirHelper::mkdir($dir);   
	 	$post = $this->data($imagecache_id);
	 	$sets = unserialize($post->memo); 
	    $load = \FuelImage::load($original_file);  
	    if(!$sets) return; 
	    foreach($sets as $k=>$value){ 
	    	 switch($k){
				case 'bgcolor':
					$load = $load->config($k, $value); 
					break;
				case 'quality':
					$load = $load->config($k, $value); 
					break;  
				case 'resize':
					if($value['width'] && $value['height'])	 
						$load = $load->resize($value['width'],$value['height'],$value['checkbox'], $value['checkbox']);
					break; 	
				case 'watermark':
					//watermark('watermark.ext', "top left", 15);
					$file = path('public').'uploads/watermark/'.$value['file'];
					if(!file_exists($file)) continue; 
					switch($value['position']){
						case 1:
							$position = "top left";
							break;
						case 2:
							$position = "top middle";
							break;
						case 3:
							$position = "top right";
							break;
						case 4:
							$position = "center left";
							break;
						case 5:
							$position = "center middle";
							break;
						case 6:
							$position = "center right";
							break;
						case 7:
							$position = "bottom left";
							break;
						case 8:
							$position = "bottom middle";
							break;
						case 9:
							$position = "bottom right";
							break;
					} 
					$load = $load->watermark($file, $position,$value['padding']);
					break; 
				case 'crop_resize': 
					$load = $load->crop_resize($value['width'], $value['height']);
					break; 
				case 'crop':
					if($value['x1'] && $value['x2'] && $value['y1'] && $value['y2'])
						$load = $load->crop($value['x1'], $value['y1'],$value['x2'],$value['y2']);
					break;
				case 'rotate':
					//->rotate(-90);
					$load = $load->rotate($value);
					break;
				case 'border':
					if($value['border'] && $value['color'])
					$load = $load->border($value['border'], $value['color']);
					break;
				case 'rounded': 
					$load = $load->rounded($value);
					break; 
			} 
	    } 
		//生成新的图片  
		$load->save($new);   
		header('Content-type: image/jpeg');  
		return file_get_contents($new);  
		 
	}

}