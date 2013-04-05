<?php
/**
* 
*/
class Translation extends Obj{
	public $key;
	public $fromkey;
	function __construct($key=null,$fromkey=null){
		parent::__construct();
		$this->key = $key;
		$this->fromkey = $fromkey;
	}
	function api($content=null){ 
		$keyfrom = $this->fromkey;
		$key = $this->key;
		$content = urlencode(strip_tags(trim($content)));	 
		
		$url = "http://fanyi.youdao.com/openapi.do?keyfrom=$keyfrom&key=$key&type=data&doctype=json&version=1.1&q=$content"; 
  		$response = json_decode(file_get_contents($url));
 		return $response->translation[0];
	}
}