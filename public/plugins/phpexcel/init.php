<?php namespace Modules\Phpexcel;

class Init{ 
    
 	static function view($params){ 
 	 
 	}
 	static function xls_to_array($inputFileName){
 		/** Include path **/
		set_include_path(__DIR__.'/PHPExcel'); 
		/** PHPExcel_IOFactory */
		include 'PHPExcel/IOFactory.php';  
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName); 
		$out = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);  
		return $out;
 	}
	 
	
}