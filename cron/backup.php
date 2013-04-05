<?php
include '../application/mysql.php';
$db->query("SHOW VARIABLES LIKE  '%basedir%'"); 
$row = $db->first();
foreach($row as $k=>$v){
	$k = strtolower($k);
	if($k=='value')
		$bin = $v.'/bin/';
}
if(!$bin) exit;
$HOST = $mysql['host'];
$USERNAME = $mysql['username'];
$PASSWORD = $mysql['password'];
$DATABASE = $mysql['database'];
//if(is_dir(__DIR__.'/dbbackup/'))
//	$file = __DIR__.'/dbbackup/'.date('Ymd-H-i-s',time()).'.sql';
//else{
	$dir = __DIR__."/../bundles/dbbackup/data/$DATABASE/";
	if(!is_dir($dir)) DirHelper::mkdir($dir);   
	$file = $dir.date('Ymd-H-i-s',time()).'.sql';
//}
$sql = "{$bin}mysqldump -u$USERNAME -p$PASSWORD   $DATABASE > $file ";
@exec($sql); 
