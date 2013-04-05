<?php namespace Plugins\Youdao;
class Init{
	static function view($params){
		echo 1;exit;
		$content = $params['content'];
		$keyfrom = $params['content']?:'wjqtaichi';
		$key= $params['content']?:'338075910'
		$content = urlencode(trim($content));	 
		$url = "http://fanyi.youdao.com/openapi.do?keyfrom=$keyfrom&key=$key&type=data&doctype=json&version=1.1&q=$content"; 
 		$response = json_decode(file_get_contents($url));
 		return $response->translation[0];
	}
}