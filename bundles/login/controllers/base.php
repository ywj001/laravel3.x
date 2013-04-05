<?php
/**
 * 第三方登录
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Login_Base_Controller extends Base_Controller {
 	public $config;
 	public $url;
	public $app_key;
	public $app_secret;
	public $oauth_id; 
	public $auth;
	public $type;
 	function init(){  
 		//判断权限
 		//$this->has_access("module.dbbackup");
 		//Menu::active(array('module','dbbackup'));
 		//CMS::set('navigation',__('admin.dbbackup'));
 		session_start();   
        include __DIR__.'/../libraries/oauth2/Provider.php';
        include __DIR__.'/../libraries/oauth2/OAuth2.php';
        include __DIR__.'/../libraries/oauth2/Exception.php';
        include __DIR__.'/../libraries/oauth2/Token.php';
        $this->config = include __DIR__.'/../config.php'; 
 	}
 	function get_user_info($access_token){
		$this->auth =  OAuth2::provider($this->type, array(
	    	'id' =>$this->app_key, 
   			'secret' => $this->app_secret, 
	    )); 
	    $token = OAuth2_Token::factory('access', array('access_token'=>$access_token));  
        return  $this->auth->get_user_info($token);
 	}
 	
 	function oauth_url(){
 		$row = (object)$this->config[$this->type]; 
		$this->oauth_id = $row->id; 
		$this->app_key = $row->app_key;
		$this->app_secret = $row->app_secret;
		$this->url = url('login/'.$this->type.'/return?refer='.refer()); 
 	}
 	
 	function oauth_save($me){
 	 	$id = $uuid = $me['uuid'];
 	 	$me['type'] = $this->type;  
	 	$node = node_one('oauth',array('where'=>array(array('uuid','=',$uuid)))); 
	 	if($node->id){
	 		$me['id'] = encode($node->id);
	 	}
	 	 
	 	$id = node_save('oauth',$me);
	 	//会员登录
	 	Client::login($id);
 	}
 	
 	 

}