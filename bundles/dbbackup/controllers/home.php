<?php
/**
 * 数据库备份
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Dbbackup_Home_Controller extends Core_Base_Controller {
	public $mysql_path;
	public $db_name;
	public $db_pwd;
	public $data;
 	function init(){  
 		//判断权限
 		$this->has_access("module.dbbackup");
 		Menu::active(array('module','dbbackup'));
 		CMS::set('navigation',__('admin.dbbackup'));
 		$sql = "SHOW VARIABLES LIKE  '%basedir%'";
 		$row = DB::query($sql);
 		$row = $row[0];
 		$this->mysql_path = $row->value.'/bin/'; 
 		$this->db_user = Config::get('database.connections.mysql.username');
 		$this->db_pwd = Config::get('database.connections.mysql.password');
 		$this->db_name = Config::get('database.connections.mysql.database');
 		$dir = Bundle::path('dbbackup').'data/'.$this->db_name;
 		if(!is_dir($dir))
 			mkdir($dir,true);
 		$this->data = $dir.'/'.date('Ymd-H-i-s',time()).'.sql'; 
 		//Menu::active('module');
 	}
 	function action_index(){
 		$dbdir = Bundle::path('dbbackup').'data';  
 		$list = scandir($dbdir);
 		foreach($list as $v){
 			if($v!='.' && $v!='..' && $v!='.svn'){
 				$path[$v]['name'] = $v;
 				$file = scandir($dbdir."/$v");
 				$path[$v]['files'] = $file;
 			}
 		} 
 		 
 		return View::make('dbbackup::home.index')
 				->with('path',$path)
 				->with('dbdir',$dbdir);
 	}
 	function action_restore(){
 		$bin = $this->mysql_path;
 		$USERNAME = $this->db_user;
 		$PASSWORD = $this->db_pwd;
 		$DATABASE = $this->db_name;
 		$file = __DIR__.'/../data/'.$_GET['name'];
 		if(Auth::user()->id!=1){
 			return Redirect::to_action('dbbackup/home/index')
				->with('error',__("admin.access deny")); 
 		}
 		if(!file_exists($file))  {
 			return Redirect::to_action('dbbackup/home/index')
				->with('error',__("admin.file not exists")); 
 		}
 		$sql = "{$bin}mysqldump -u$USERNAME -p$PASSWORD --add-drop-table --no-data $DATABASE | grep ^DROP | mysql -u$USERNAME -p$PASSWORD $DATABASE";
		exec($sql);  
		$data = "{$bin}mysql -h $HOST -u $USERNAME --password=$PASSWORD $DATABASE < $file";  
		exec($data); 
		return Redirect::to_action('dbbackup/home/index')
				->with('success',__("admin.restore database success")); 
 	}
 	
 	
 	function action_backup(){
 		$query = $this->mysql_path."mysqldump  -u".$this->db_user."  -p".$this->db_pwd ."   ".$this->db_name." > ".$this->data;   
		@exec($query);  
		return Redirect::to_action('dbbackup/home/index')
				->with('success',__("admin.backup database #:name# success",array('name'=>$this->db_name))); 
 	}
 	
 	function action_down(){
 		$name = Bundle::path('dbbackup').'data/'.$_GET['name'];
 		$to = $_GET['ext'].'.sql';
 		if(!file_exists($name)){
 			return Redirect::to_action('dbbackup/home/index')
				->with('success',__("admin.file not exist"));
 		}
 		return Response::download($name,$to);
 	}

}