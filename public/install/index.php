<?php
error_reporting(E_ALL & ~(E_STRICT | E_NOTICE));
function new_replace($body,$replace=array()){ 
	if(!$replace) return $body;
	foreach($replace as $k=>$v){
		$body = str_replace($k,$v,$body);
	}
 	return $body;
}
$step = $_GET['step']?$_GET['step']:2;
		if(file_exists('lock')){ 
			$step = 5;
			include 'view.php';
			
			return;
		} 
		$test = array(
			array(
				'file'=>'Require php53',
				'write'=> (phpversion()>=5.3)?true:false, 
				'php'=>true
			),
			array(
				'file'=>'PHP extension mcrypt',
				'write'=> extension_loaded('mcrypt'), 
				'php'=>true
			),
			/*array(
				'file'=>__('PHP extension fileinfo','install'),
				'write'=> extension_loaded('fileinfo'), 
				'php'=>true
			),*/
			array(
				'file'=>'PHP extension mbstring',
				'write'=> extension_loaded('mbstring'), 
				'php'=>true
			),
			
			array(
				'file'=>'PHP extension pdo_mysql',
				'write'=> extension_loaded('pdo_mysql'), 
				'php'=>true
			),
			 
			
		 
			 
		);
		$base = dirname(__FILE__).'/../../'; 
		$check[] = $db_file = $base.'application/config/database.php'; 
		$check[] = $base.'public/uploads';
		$check[] = $base.'bundles/dbbackup/data';
		$check[] = $base.'storage'; 

		foreach ($check as $v) {
			$test[] = array(
				'file'=>$v,
				'write'=>is_writeable($v),
				'code'=> array('mkdir '.$v, 'chmod a+w '.$v)
			);
		}
		
		if($_POST){
			$flag = false;
			$hostname = trim($_POST['host']);
			$username = trim($_POST['user']);
			$database = trim($_POST['database']);
			$password = trim($_POST['pwd']);
			if(!$hostname || !$username || !$password){
				$error='All Filed Is Require'; 
				$step = 3;
				$flag = true;
			}
			else{
				if(!$link = @mysql_connect($hostname,$username,$password)){
					$error='Connect mysql error'; 
					$step = 3;
					$flag = true; 
				}  
				elseif(!mysql_select_db($database)){
					if (!mysql_query("CREATE DATABASE $database",$link)){
						$error = 'Select databse error and try create database error'; 
						$step = 3; 
					}
					$flag = true; 
				}  
				if(!$flag){
					//Ð´¿â
					$dataReader = mysql_query("SHOW VARIABLES LIKE  '%basedir%'");
					$dataReader = mysql_fetch_array($dataReader); 				 
			 		$bin =  $dataReader['Value'].'/bin/';
					 $sql = dirname(__FILE__).'/install.sql';
					 $ex = $bin."mysql     -u".$username."  -p".$password ."   ".$database." < ".$sql;    
					 exec($ex);
					 $word = file_get_contents($db_file);
					 $word = new_replace($word,array(
					 	'{{host}}'=>$hostname,
					 	'{{database}}'=>$database,
				 		'{{username}}'=>$username,
				 		'{{password}}'=>$password,
					 )); 
					@file_put_contents($db_file,$word); 
					@file_put_contents(dirname(__FILE__).'/lock','mincms');
					$step = 5;
				}
			}

		}
	 
    include 'view.php';