<?php

$config = include __DIR__.'/application/config/database.php';

$mysql = $config['connections']['mysql'];

$db = new db;
$db->connect($mysql); 

function dump($str){
	print_r('<pre>');
	print_r($str);
	print_r('</pre>');
}
class db{
	protected $_conn;
	protected $_query;
	function connect($mysql){
		$this->_conn = mysql_connect($mysql['host'],$mysql['username'],$mysql['password']);
		mysql_select_db($mysql['database'],$this->_conn);
	}
	function query($sql){
		$this->_query = mysql_query($sql,$this->_conn);
	}
	function first(){
		return mysql_fetch_array($this->_query,MYSQL_ASSOC);
		return $data;
	}
	function get(){
		while($list = mysql_fetch_array($this->_query,MYSQL_ASSOC)){
			$data[] = $list;
		}
		return $data;
	}
}

 
