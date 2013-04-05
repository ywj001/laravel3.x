<?php namespace Packages;
class Loadimg{
	function __construct(){
		include_once path('app').'vendor/Snoopy.class.php';
 		include_once path('app').'vendor/simple_html_dom.php';
	}
	
	function init($src){
		set_time_limit(0);
		$src = urldecode($src);
		if(strpos($src,"http://")===false  && strpos($src,"https://")===false )
	       	   $flag = true; 
       $host = $_SERVER['HTTP_HOST'];
       $host = str_replace("http://",'',$host);
       $host = str_replace("http://www.",'',$host);
       if(strpos($src,$host)!==false ) return;  
       if(strpos($src,'/')==0 ) return; 
       $arr = getimagesize($src);  
       if($arr['bits']<1) return ;
       $e = $this->file_exists($src);
       if($e===false) return;
       if(!$e){
       		$up = \CMS::upload($src);  
       		return \URL::base().'/'.$up->path;
       }  
       return '/'.$e->path;
	}
	function file_exists($url){
 		$data = file_get_contents($url);
 		if(!$data) return false;
		$uniqid =  md5($data);
		$row = \DB::table('files')->where('uniqid','=',$uniqid)->first(); 
		return $row?$row:false;
 	}

}