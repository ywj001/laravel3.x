<?php 
class Lang extends Laravel\Lang{
	public function get($language = null, $default = null)
	{
		$line = parent::get($language, $default);
		if($line && strpos($line,'.')!==false){
			$arr = explode('.',$line);
			$line = $arr[1];
		}
		return $line;
	}
}