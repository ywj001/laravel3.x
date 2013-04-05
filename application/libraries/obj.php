<?php
class Obj{

	function __construct(){
		if(method_exists($this, 'init'))
			$this->init();
	}
}