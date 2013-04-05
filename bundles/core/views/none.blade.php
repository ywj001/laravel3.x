<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{CMS::get('title',__('admin.admin'))}}</title> 
{{ HTML::style('misc/bootstrap/css/bootstrap.min.css');}}
{{ HTML::style('misc/fortawesome/css/font-awesome.min.css');}}
{{ HTML::style('css/admin/default.css');}}
{{ HTML::script('misc/jquery/jquery-1.8.0.min.js'); }}
{{ HTML::script('js/comm.js'); }} 
{{ HTML::script('misc/jquery/jquery.form.js'); }} 
{{ HTML::script('misc/jui/js/jquery-ui.js'); }} 
{{ HTML::style('misc/jui/css/flick/jquery-ui.min.css');}} 
{{ HTML::script('misc/bootstrap/js/bootstrap.min.js');}}   
{{ \Plugins\Colorbox\Init::view();}}
 
{{ Asset::styles();}}
{{ Asset::scripts();}} 
</head>
<body> 
	<div style="padding-top:5px;min-width:500px;">
		<div class="container-fluid">
			<section>  
				@yield('content') 
				<div style="height:5px;"></div>
			</section>
		</div>
	</div>
<div id='update' class='fixed_message' style='display:none;' >
	
</div>
	 
	{{ CMS::render();}}
</body>
</html>