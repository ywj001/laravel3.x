<?php

class Front_Controller extends Base_Controller { 
	public $theme;
	public function init()
	{ 
		if($this->theme)
			Config::set('mincms.theme',$this->theme);
		\Event::listen('view.filter', function($view){
			 return Minfy::minify($view);
		});
	}
	function theme($name){ 
		return theme($name);
	}

}