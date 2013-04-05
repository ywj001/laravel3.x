<?php namespace Plugins\Insertimg;

class Node{ 
	static function allow(){
		return array('file');
	}
	static function config(){
		return array( 
			'more'=>'',  
		);
	}
	 
	
}