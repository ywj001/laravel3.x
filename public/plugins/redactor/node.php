<?php namespace Plugins\Redactor;

class Node{ 
	static function allow(){
		return array('textarea');
	}
	static function config(){
		return array( 
			'upload'=>'',  
		);
	}
}