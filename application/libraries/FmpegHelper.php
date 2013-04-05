<?php  
/**
 * @author Sun Kang <68103403@qq.com>
 * @link http://www.mincms.com/
 * @copyright 2013-2013 MinCMS Software
 * @license http://www.mincms.com/license/
 */
class FmpegHelper{
	public $bin = 'ffmpeg';
	
	function __construct($bin){ 
		$this->bin = $bin;
		return $this;
	}

	function image($in,$img,$width=400,$height=300,$time="00:00:08"){
		if(!file_exists($in)) return false;		 
		$cmd = $this->bin." -i $in -ss ".$time."  -vframes 1 -r 1 -ac 1 -ab 2 -s ".$width."x".$height." -f image2 $img"; 
 		if(@exec($cmd))		 
			return true;
		return false;
	}
 	
	function video($in,$out){ 
		$cmd = $this->bin." -i ".$in."   -acodec copy -vcodec copy -copyts  ".$out; 
 		if(@exec($cmd))
			return true;
		return false;
	}
 
}