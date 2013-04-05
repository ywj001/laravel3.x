<?php
/**
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class JS{
	static function encode($value,$safe=false){ 
		return  CJavaScript::encode($value,$safe);
	}
}