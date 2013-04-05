<?php 
class Asset extends Laravel\Asset{
	
	public static function container($container = 'default')
	{
		if ( ! isset(static::$containers[$container]))
		{
			static::$containers[$container] = new Asset_Container($container);
		} 
		return static::$containers[$container];
	}
	  
	 
}
class Asset_Container extends Laravel\Asset_Container{ 
	
	/**
	 * Get all of the registered assets for a given type / group.
	 *
	 * @param  string  $group
	 * @return string
	 */
	protected function group($group)
	{
		if ( ! isset($this->assets[$group]) or count($this->assets[$group]) == 0) return '';

		$assets = '';

		foreach ($this->arrange($this->assets[$group]) as $name => $data)
		{
			$assets .= $this->asset($group, $name);
		}
		
		return $assets;
	}
	
	/**
	 * Get the links to all of the registered CSS assets.
	 *
	 * @return  string
	 */
	public function styles()
	{ 
		if(Config::get('mincms.minfy_css_file')===true) 
			return $this->_minfy('style'); 
			
		return $this->group('style');
	}

	/**
	 * Get the links to all of the registered JavaScript assets.
	 *
	 * @return  string
	 */
	public function scripts()
	{  
		if(Config::get('mincms.minfy_js_file')===true){
			return $this->_minfy('script'); 
		}
		return $this->group('script');
	}
	
	protected function _minfy($type){  
		if(!$this->assets[$type])return;
		if(!is_writable(path('public').'cache')){
			return $this->group($type);
		}
		foreach($this->assets[$type] as $k=>$v){ 
			$key .=$k; 
		}
		if(!is_dir(path('public').'cache')){
			mkdir(path('public').'cache',775);
		}
		$ext = '.css';
		if($type=='script')
			$ext = '.js';
		$name = 'cache/'.md5($key).$ext;
		$file = path('public').$name;  
		if(!file_exists($file)){
			foreach($this->assets[$type] as $k=>$v){ 
				$v['source'] = str_replace(URL::base(),'',$v['source']);
				if(file_exists(path('public').$v['source']))
					$data .= file_get_contents(path('public').$v['source']); 
			}
			$d .= JSMin::minify($data);
			if($d)
				file_put_contents($file,$d); 
			//return $this->group($type);
		} 
		$script = '<link href="'.URL::base().'/'.$name.'" rel="stylesheet" type="text/css">';
		if($type=='script')
			$script = '<script src="'.URL::base().'/'.$name.'"></script>';
		return $script;
	}

 
}