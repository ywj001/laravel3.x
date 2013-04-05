<?php
/**
 * Hook
 *
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class Core_Plugin_Controller extends Base_Controller {
 	
 	function action_index($name,$function=null){ 
 		 $class = "Plugins\\".ucfirst($name).'\Init';    
		 return call_user_func($class."::$function",$_GET);   
 	}

}