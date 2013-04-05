<?php
/**
 * 会员操作
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Client{
	static function uid(){
 		return Cookie::get('uuid'); 
	}

	static function oauth($value,$name='oauth'){
 		$m = node($name,$value);
		return $m;
	}
 	static function access(){
 		return Cookie::get('uuid');
 	}
 	static function user(){
 		$id = static::access();
 		if($id){
 			$id = decode($id);
 			if($id<1) return false;
 			return node('oauth',$id);  
 		}
 	}
 	static function login($uid,$time=0){
 		Cookie::put('uuid', encode($uid), $time);
 	}
 	
 	static function logout(){
 		Cookie::forget('uuid');
 	}
 
 }