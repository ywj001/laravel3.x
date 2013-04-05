<?php 
/**
 * 下载远程图片
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Httpimage_Home_Controller extends Core_Base_Controller {
 	function init(){
 		//判断权限
 		$this->has_access("module.httpimage");
 		Menu::active(array('module','httpimage'));
 		CMS::set('navigation',__('admin.download images'));
 		include_once path('app').'vendor/Snoopy.class.php';
 		include_once path('app').'vendor/simple_html_dom.php';
 	}
 
 	function action_index(){   
 		Plugins\Masonry\Init::view(array());
 		return View::make('httpimage::index'); 
 	}
 	
 	function file_exists($url){
 		$data = file_get_contents($url);
		$uniqid =  md5($data);
		$row = DB::table('files')->where('uniqid','=',$uniqid)->first();
		if(!$row)
			$span = "<span class='icon-cloud-download ajax icon-2x httpimg2' rel='".$url."'></span>";
		else{
			$span = "<span class='httpimg' >".__('admin.had downloaded')."</span>";
		}
		return $span;
 	}
 	function action_get(){ 
 		error_reporting(0);
 		set_time_limit(60);
 		Plugins\Masonry\Init::view(array());
 		
 		$url = trim($_REQUEST['url']); 
 		$min_width = $_REQUEST['width']?:100; // 最小宽度
		$min_height = $_REQUEST['width']?:100;//最小长度 
		if(!$url) return; 
		$url = urldecode($url);
		if(in_array(strtolower(File::extension($url)),array('jpg','png','gif','bmp','jpeg'))){
			$span = $this->file_exists($url);
			if($url)
				echo "<div class='item'>".HTML::image($url).$span."</div>";
			return ;
		} 
		$url = urldecode($url);
 	 	$snoopy = new Snoopy; 
		$snoopy->read_timeout = 60;  
 	 	$snoopy->maxredirs = 3; 
 	    $snoopy->fetch($url); 
 	 	if($snoopy->fetch($url))
		{  
		 	$content = $snoopy->results;
		}else{
			 exit("<div class='alert alert-error'>".__('admin.load http images failed').'</div>');
		}  
		$html = str_get_html($content);    
		if(!$html) {
			exit("<div class='alert alert-error'>".__('admin.load http images failed').'</div>');
		} 
		/**
		* 抓取所有图片
		* 图片过滤长宽
		*/
		foreach($html->find('img') as $element) {
			   $flag = false;
		       $src = $element->src ; 
		       if(strpos($src,"http://")===false  && strpos($src,"https://")===false )
		       	   $flag = true; 
		       if(strpos($src,$url)===false && $flag===true ){
		       	  $url = str_replace('://','{{##}}',$url);
		       	  $url = substr($url,0,strpos($url,'/'));
		       	  $url = str_replace('{{##}}','://',$url);
		       	  $src = $url.$src; 
		       }
		       $arr = @getimagesize($src);  
		       $w = $arr[0];
		       $h = $arr[1];
		       if($w>=$min_width && $h>=$min_height){
			       	$files[] = $src;
		       }  
		}
		
		if($files){
			foreach($files as $v){
				$span = $this->file_exists($v);
				if($v){
					$flag = true;
					$out .= "<div class='item'>".HTML::image($v).$span."</div>";
				}
			}
			if(true === $flag)
				echo $out.$end;
		}
		else{
		 
			$header = get_headers($url,true);
			foreach($header as $k=>$v){
				$headers[strtolower($k)] = strtolower($v);
			} 
			if(strpos($headers['content-type'],'image') !== false){ 
				$span = $this->file_exists($url); 
				echo "<div class='item'>".HTML::image($url).$span."</div>";
			} else{
				exit("<div class='alert alert-error'>".__('admin.load http images failed').'</div>');
			} 
		}
		return;
 	}
 	function action_load(){   
 		$url = trim($_POST['url']);
 		if(!$url) return false; 
		$rt = CMS::upload($url);  
 	}
 	
  
}