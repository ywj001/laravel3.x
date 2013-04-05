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
class Login_Qq_Controller extends Login_Base_Controller {
 	public $type='qq';
 	 
 	/**
 	* load some required files
 	*/
	function init(){
		parent::init();  
	 	$this->oauth_url();
		
	}
 	public function action_index()
	{ 
	 	$code_url = "https://graph.qq.com/oauth2.0/authorize?client_id=".$this->app_key."&redirect_uri=".urlencode($this->url)."&response_type=code";  
		header("location:$code_url"); 
 		exit;
	}
	function action_return(){
		$this->auth = OAuth2::provider($this->type, array(
	    	'id' =>$this->app_key, 
	        'secret' => $this->app_secret, 
		));     
		$params['redirect_uri'] = $this->url;
		$params['grant_type'] = 'authorization_code';
		$o = $this->auth->access($_GET['code'],$params);
		$access_token = $o->access_token;
		$this->save_login($access_token);
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
		 	$me['url']  = $info['figureurl_1'];  
			$this->oauth_save($me);  
			
		} catch (OAuthException $e) {
			 
			 
		}
	} 

}