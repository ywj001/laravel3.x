<?php
include __DIR__.'/base.php';
/**
 * 第三方登录
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Login_Sina_Controller extends Login_Base_Controller {
 	public $type='sina';
 	 
 	/**
 	* load some required files
 	*/
	function init(){
		parent::init();  
		include __DIR__.'/../libraries/SaeTOAuthV2.php';
	 	$this->oauth_url();
		
	}
 	public function action_index()
	{ 
	 	$o = new \SaeTOAuthV2( $this->app_key , $this->app_secret );  
		$code_url = $o->getAuthorizeURL($this->url);  
		header("location:$code_url"); 
 		exit;
	}
	function action_return(){
		$o = new \SaeTOAuthV2( $this->app_key , $this->app_secret); 
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = $this->url;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
				$access_token = $token['access_token'];
				$c = new \SaeTClientV2($this->app_key , $this->app_secret, $access_token );  
				$info = $c->get_uid();
				dump($info);exit;
				$uid = $info['uid']; 
				$me = $c->show_user_by_id($uid );   
				$me['nickname'] = $me['screen_name'];
				$me['options'] = array('url'=>$me['profile_url']);
			 	$uid = $info['uid']; 
				$me['uuid'] = $uid;
				$me['name'] = $info['nickname']; 
				$me['email']  = $info['email']; 
			 	$me['token']  = $access_token; 
			 	$me['url']  = $info['figureurl_2'];  
				$this->oauth_save($me);  
				
			} catch (OAuthException $e) {
			 
			}
		}
		 
	 	return Redirect::to($_GET['refer'])
						->with('success',__("admin.login success")); 
	}
	
	protected function save_login($access_token){ 
		try
        {     
        	$info = $this->get_user_info($access_token);          
			$uid = $info['uid']; 
			$me['uuid'] = $uid;
			$me['name'] = $info['nickname']; 
			$me['email']  = $info['email']; 
		 	$me['token']  = $access_token; 
		 	$me['url']  = $info['figureurl_2'];  
			$this->oauth_save($me);  
			
		} catch (OAuthException $e) {
			 
			 
		}
	} 

}