<?php

Route::get('download', function()
{
	$file = $_GET['id'];
	$name = $_GET['name']?:file_name($file); 
	return Response::download(path('public').$file, $name);
});
 

Route::controller(Controller::detect());
Route::controller(Controller::detect('core'));
$cache = new QCache_PHPDataFile;
$modules = $cache->get('bundles'); 
if($modules){
	foreach($modules as $k=>$v){
		Route::controller(Controller::detect($k));
	}
} 
Route::get('imagecache',"core::imagecache@index");

Autoloader::namespaces(array(
   //'Modules' => path('app').'modules',
    'Plugins' => path('app').'../public/plugins', 
    'Packages' => path('app').'packages',
    'Hooks' => path('app').'hooks',
));
	
require_once __DIR__.'/function.php';



