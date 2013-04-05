<?php

class Menu{
	static $_active;
	static function init(){ 
		
		if(Auth::user()->id==1){
			$menu['content type'] = array(
				'icon'=>'tasks',
				'url'=>action('core/type/index'),
				'active'=>static::$_active
			);
		}
		if(CMS::check("system.user.index")){
			$menu['user'] = array(
				'icon'=>'user',
				'url'=>action('core/user/index'),
				'active'=>static::$_active
			);
		}
		if(Auth::user()->id==1){
			$menu['auth'] = array(
				'icon'=>'certificate',
				'url'=>action('core/auth/index'),
				'active'=>static::$_active
			);
		}
		/*$menu['views'] = array(
			'icon'=>'th-large',
			'url'=>action('core/views/index'),
			'active'=>static::$_active
		);	 */
		 
		 
		return  $menu;
	}
	static function active($name){
		static::$_active = $name;
	}
	static function get_active(){
		return static::$_active;
	}
}