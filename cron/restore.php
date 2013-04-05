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

$sql = "{$bin}mysqldump -u$USERNAME -p$PASSWORD --add-drop-table --no-data $DATABASE | grep ^DROP | mysql -u$USERNAME -p$PASSWORD $DATABASE";
@exec($sql);
$file = __DIR__.'/data/demo.sql';
$data = "{$bin}mysql -h $HOST -u $USERNAME --password=$PASSWORD $DATABASE < $file"; 
@exec($data);
