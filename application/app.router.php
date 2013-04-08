<?php 
Config::set('mincms.theme','default');

Route::get('/',function(){
	return theme('index');
});  


 