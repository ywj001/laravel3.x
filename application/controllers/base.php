<?php

class Base_Controller extends Controller {
	function __construct()
	{
		parent::__construct();
		if(method_exists($this,'init'))
			$this->init();  
		
		if(Config::get('mincms.minfy_code')===true){
			\Event::listen('view.filter', function($view){
				 return Minfy::minify($view);
			});
		}
	} 
	
	
	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}