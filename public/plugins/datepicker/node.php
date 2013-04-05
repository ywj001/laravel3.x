<?php namespace Plugins\Datepicker;

class Node{ 
	static function allow(){
		return array('text');
	}
	static function config(){
		return array( 
		 
		);
	} 
	static function insert($data){
		return strtotime($data);
	}
	static function select($data){
		return date('Y-m-d H:i',$data);
	}
	 
}