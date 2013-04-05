<?php
/**
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class FileHelper{

	static function size($filesize) {
	 $filesize =  File::size($filesize);
	 if($filesize >= 1073741824) {
	  	$filesize = round($filesize / 1073741824 * 100) / 100 . ' gb';
	 } elseif($filesize >= 1048576) {
	  	$filesize = round($filesize / 1048576 * 100) / 100 . ' mb';
	 } elseif($filesize >= 1024) {
	 	 $filesize = round($filesize / 1024 * 100) / 100 . ' kb';
	 } else {
	 	 $filesize = $filesize . ' bytes';
	 }
	 return $filesize;
	}
}