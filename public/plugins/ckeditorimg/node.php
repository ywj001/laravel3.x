<?php namespace Plugins\Ckeditorimg;

class Node{ 
	static function allow(){
		return array('textarea');
	}
	static function config(){
		return array( 
			'no'=>'',  
		);
	}
	 
	
}