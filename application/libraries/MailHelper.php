<?php  
/**
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
/*
* 发送邮件
$mailer = new MailHelper;
$to = array('123456@qq.com'=>'你好');
$title = '感谢您使用mincms';
$body = '这是内容你看得到吗？';
$mailer->send($to,$title,$body);
*
*/
class MailHelper{
	 public $mailer;
	 static $_obj;
	 public $cache;
	 public $transport;
	 public $message;
	 function __construct(){
	 	 if(!isset(self::$_obj)){ 
 			include dirname(__FILE__).'/Swift-4.2.2/lib/swift_required.php';  
	 		self::$_obj = true;
 	 	} 
 	 	$driver = Config::get('email.driver'); 
 	 	switch($driver){
 	 		case 'smtp':
 	 			$this->smtp();
 	 			break;
 	 		case 'sendmail':
 	 			$this->sendmail();
 	 			break;
 	 		case 'mail':
 	 			$this->smtp();
 	 			break;
 	 	}
 	 	$this->init();
	 }
	 function sendmail(){
	 	$agent = Config::get('email.useragent');
	 	if(!$agent)  $agent = '/usr/sbin/sendmail -bs';
	 	// Sendmail
		$this->transport = Swift_SendmailTransport::newInstance($agent);
	 }
	 function mail(){
	 	// Mail
		$this->transport = Swift_MailTransport::newInstance(); 
	 } 
	 function smtp(){ 
		$pwd = Config::get('email.password');
		$port = Config::get('email.port'); 
		$port = trim($port)?trim($port):25;
		$this->transport = Swift_SmtpTransport::newInstance(trim(Config::get('email.smtp')), $port)
			->setUsername(Config::get('email.email'))
			->setPassword($pwd); 
	 }
	 function init(){
	 	$this->mailer = Swift_Mailer::newInstance($this->transport); 
	 }
 	 function send($to,$title,$body,$attachment=false){
 	    $this->message = Swift_Message::newInstance($title)
		    ->setFrom(array(Config::get('email.email')=>Config::get('email.name')));
 	 	// Construct the message
		$message = $this->message->setTo($to)
		    ->addPart($title,'text/plain')
		    ->setBody($body,'text/html');
		if(false!==$attachment)
			$message->attach(Swift_Attachment::fromPath($attachment)); 
		// Send the email
		$this->mailer->send($message); 
 	 }
 	 

	
	

}