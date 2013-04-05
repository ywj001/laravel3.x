<?php namespace Plugins\Titleimg;

class Node{ 
	
	static function index(){
		return array('text');
	}
	static function allow(){
		return array('text');
	}
	static function config(){
		return array( 
			'is_node_index'=>'1', 
			'show_img'=>'',
			'body'=>'',  
		);
	}
	 
	
}