<?php
/**
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
 /**
 * https://manage.dev.live.com/Applications
 */
class Skydrive_Home_Controller extends Core_Base_Controller {
 
 	public $app_key = '000000004C0C5716';
 	public $app_secret = 'TZPF7ZQDbD7pM9rNONbPhvJZ3k1aKlxa';
 	public $url;
 	public $auth;
 	public $token;
 	public $api = 'https://apis.live.net/v5.0/';
 	static $_files;
 	static $_pid=array();
 	public $use_name = array('wjqtaichi.com');
 	private $scopes = array(
			"wl.basic", "wl.signin","wl.emails","wl.offline_access", "wl.signin", "wl.birthday", "wl.calendars", "wl.calendars_update",
			"wl.contacts_create", "wl.contacts_calendars", "wl.contacts_photos", "wl.contacts_skydrive",
			"wl.emails", "wl.events_create", "wl.messenger", "wl.phone_numbers", "wl.photos", "wl.postal_addresses",
			"wl.share", "wl.skydrive", "wl.skydrive_update", "wl.work_profile", "wl.applications", "wl.applications_create"
	);
 	function init(){  
 		$this->has_access("module.skydrive");
 		Menu::active(array('module','skydrive'));
 		session_start();
 		include_once path('app').'vendor/oauth2/Provider.php';
 	 	include_once path('app').'vendor/oauth2/OAuth2.php';
 	 	include_once path('app').'vendor/oauth2/Exception.php';
 	 	include_once path('app').'vendor/oauth2/Token.php';
 	 	$this->url = action('skydrive/home/return').'?';
 	}
 	function get_photos($rows){  
 		set_time_limit(60);
 		$flag = false;
 		if($rows){ 
			foreach($rows as $row){ 
				if($row->images){
					self::$_files[] = $row->images; 
				}else{ 
					if(count($this->use_name)>0 && in_array(trim($row->name),$this->use_name)) {
						$flag = true;
					} 
					self::$_pid[] = $row->id; 
					if(self::$_pid && in_array($row->parent_id,self::$_pid)){
						$flag = true;
					}
					if(strrpos($row->upload_location,'content')!==false) {
						$flag = false;
					} 
					if(false === $flag ) continue;
					$n = $row->upload_location."?sort_order=descending&access_token=".$this->token;   
					$r = @file_get_contents($n);
					$r = json_decode($r);
					$r = $r->data;
					if($r){   
						self::get_photos($r);
					}
				}
			}
		} 
		return self::$_files;
 	}
 	function action_index(){
 		set_time_limit(60);
 		$node = node('oauth',1);
 		$this->token = $node->token;
		$n = $this->api."me/albums?sort_order=descending&access_token=".$this->token;    
		$imgs = Cache::get('skdydrive');
		if(!$imgs){
			$r = @file_get_contents($n);
			$r = json_decode($r);
			$rows = $r->data;  
			$imgs = $this->get_photos($rows);   
			Cache::put('skdydrive',$imgs, 10);
		}
 		return View::make('skydrive::home.index')->with('imgs',$imgs); 
 	}
 	public function action_login()
	{
	 	$url = "https://login.live.com/oauth20_authorize.srf?client_id=".$this->app_key."&scope=".implode("%20",$this->scopes)."&response_type=code&redirect_uri=".urlencode($this->url);
	 	echo $url;exit;
   		header("location:$url"); 
 		exit; 
	}
	
 	function action_return(){ 
		$this->auth = OAuth2::provider('windowslive', array(
	    	'id' =>$this->app_key, 
	        'secret' => $this->app_secret, 
		));      
		$params['redirect_uri'] = $this->url;
		$params['grant_type'] = 'authorization_code';
		$o = $this->auth->access($_GET['code'],$params); 
		$access_token = $o->access_token;
	  	
	  	$token = OAuth2_Token::factory('access', array('access_token'=>$access_token)); 
        $info = $this->auth->get_user_info($token);    
		$uid = $info['uid'];  
		$me['uid'] = $uid;
		$me['name'] = $info['name']; 
		$me['token']  = $access_token; 
		$me['nickname'] = $info['nickname']; 
	 	$me['options']  = $info['urls']; 
	 	$me['type']  = 'msn'; 
	 	$node = node('oauth',array('where'=>array(array('uid','=',$uid),array('type','=','msn')),'limit'=>1));
	 	if($node->id){
	 		$me['id'] = encode($node->id);
	 	}
	 	node_save('oauth',$me);
	 	echo 'success';
	}
 	
  

} 