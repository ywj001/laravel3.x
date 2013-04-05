<?php 
class HTML extends Laravel\HTML{
	static $_scripts;
	static $_styles;
	public static function script($url, $attributes = array())
	{
		$url = URL::to_asset($url);

		return '<script src="'.$url.'"'.static::attributes($attributes).'></script>'.PHP_EOL;
	}
	public static function style($url, $attributes = array())
	{
		$defaults = array('media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet');

		$attributes = $attributes + $defaults;

		$url = URL::to_asset($url);

		return '<link href="'.$url.'"'.static::attributes($attributes).'>'.PHP_EOL;
	}
}