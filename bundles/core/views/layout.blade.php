<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>裴祖荫太极拳 后台管理</title> 
    {{HTML::script('misc/jquery/jquery-1.7.2.min.js');}} 
<?php 
   $theme = Helper::theme_language('theme','theme',true)?:'default';  
   $li = array(
   	   	'default'=>'#fff',
   	    'default2'=>'#000', 
   	    'cute'=>'fefefe', 
		'blue2'=>'#45aeea',
		'blue'=>'#54b4eb', 
		'gree'=>'#013435',
		//'red'=>'#ad1d28', 
		'red2'=>'#ce4213',
		//'black3'=>'#080808',
		'black2'=>'#3a3f44',
		'simplex'=>'#fff',
   );
   if(in_array($theme,array('blue2','default2'))){
   		$top_class = 'navbar-inverse ';
   		$theme = substr($theme,0,-1);
   }
  // assets("misc/bootstrap/css/bootstrap.min.css");
   assets("misc/bootstrap/css/bootstrap_$theme.min.css");
   assets("misc/bootstrap/css/bootswatch_$theme.css"); 
   assets("misc/bootstrap/css/bootstrap-responsive.min.css");
   assets("misc/fortawesome/css/font-awesome.min.css");
   assets("css/admin/default.css"); 
   assets("js/comm.js");
   assets("misc/jquery/jquery.form.js");
   assets('misc/jui/jquery-ui.js'); 
   assets("misc/jui/css/flick/jquery-ui.min.css");
   assets("misc/bootstrap/js/bootstrap-dropdown.js");   
   CMS::script('nav',"
   $('.nav-collapse .nav').find('.dropdown').each(function(){
   		if($(this).find('li').length<1){
   			$(this).remove();
   		}
   });
   ");
   
?>
<?php
 
	plugin('fancybox',array('tag'=>'.fancybox'));
	plugin('superbox');
	plugin('lightbox');
	plugin('totop'); 
 	 CMS::script('menu_jump',"$('.pull-right span.li').click(function(){
	   	window.location.href = $(this).attr('rel');
	   });");
?> 
 
 
<?php
if(\Session::has('success')){
	$noty = \Session::get('success');
	$noty_type = 'success'; 
}else if(\Session::has('error')){
	$noty = \Session::get('error');
	$noty_type = 'error';

}  
 

if($noty){  
plugin('noty',array(
	'text'=>"".$noty."",
	'layout'=>'top',
	'type'=>$noty_type,
	'animation'=>array(
		'open'=>array('height'=>'toggle'),
		'close'=>array('height'=>'toggle'),
		'easing'=>'swing',
		'speed'=>500,
	),
	'timeout'=>1000
    
)); 
}else{
	plugin('noty');
}
?> 
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
	 <div class="navbar {{$top_class}} navbar-fixed-top ">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> 
				<a class="brand" href="{{action('core/home/index');}}">{{__('admin.home')}}</a>
				<div class="nav-collapse">
					<ul class="nav">
						<li class="dropdown @if(is_array(Menu::get_active()) && in_array('content',Menu::get_active()))
							active
							@endif">
							<a href="#" class="dropdown-toggle " data-toggle="dropdown" >
									{{__('admin.content')}} <b class="caret"></b></a>
							<?php 
								$rows = \DB::table('fields')->where('pid','=',0)
								 	->order_by('sort','desc')
								 	->order_by('id','desc')
								 	->get();  
								if($rows){
									echo '<ul class="dropdown-menu">'; 
									foreach($rows as $row){
										unset($active);
										if(is_array(Menu::get_active()) && in_array($row->value,Menu::get_active())){
											$active="class='active'";
										} 
										if($row->lock==1){
									 		if(Auth::user()->id!=1){
									 			continue;
									 		}
								 		}
								 		if(CMS::check("node.".$row->value.".index")){
										echo"<li $active >".HTML::link(action('core/node/index',array('name'=>$row->value)),$row->label).'</li>';
										}
									}
									echo '</ul> ';
								} 
							?> 
						</li>
						
						<li class="dropdown @if(is_array(Menu::get_active()) && in_array('system',Menu::get_active()))
							active
							@endif">
							<a href="#" class="dropdown-toggle " data-toggle="dropdown" >
									{{__('admin.system')}} <b class="caret"></b></a>
							<?php  
								echo '<ul class="dropdown-menu">';
							 
								if(is_array(Menu::get_active()) && in_array('imagecache',Menu::get_active())){
									$imagecache_active="class='active'";
								}
								if(is_array(Menu::get_active()) && in_array('taxonomy',Menu::get_active())){
									$taxonomy_active="class='active'";
								}
								if(CMS::check('system.taxonomy.index'))
								echo "<li $taxonomy_active >".HTML::link(action('core/taxonomy/index'),__('admin.taxonomy')).'</li>';
								if(CMS::check('system.imagecache'))
									echo "<li $imagecache_active>".HTML::link(action('core/imagecache/admin'),__('admin.imagecache')).'</li>';  
								echo '</ul> '; 
							?> 
						</li>
								
						<li class="dropdown @if(is_array(Menu::get_active()) && in_array('module',Menu::get_active()))
							active
							@endif
							">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									{{__('admin.module')}}<b class="caret"></b></a>
									<?php
										$cache = new QCache_PHPDataFile;
										$modules = $cache->get('bundles');  
									 
										if($modules){
									?>	
							 <ul class="dropdown-menu">
							 	@if(Auth::user()->id==1) 
							 	<li <?php 
							 			if(is_array(Menu::get_active()) && in_array('module_index',Menu::get_active()))
							 			echo "class='active'";
							 			?>><a href="{{action('core/module/index');}}"  >  {{__('admin.module list')}}</a></li>		
						 		@endif
								<?php 
								foreach($modules as $k=>$v){
									unset($active);
									if(is_array(Menu::get_active()) && in_array($k,Menu::get_active())){
										$active="class='active'";
									}
								?>
								@if(CMS::check("module.$k"))
								<li <?php echo $active;?>><a href="{{action($k.'/home/index')}}" title="{{$k}}">{{__('admin.'.$k)}}</a></li>
								@endif
								<?php }?>
						    </ul>
							<?php 
								}
							?>
						</li>
		
						<?php $menus = Menu::init();?>
						@if($menus)
							@foreach($menus as $label=>$menu)
							<li @if($menu['active']==$label) 
								class='active'
								@endif
								>
								<a href="{{$menu['url']}}"> 
										<i class="icon-{{$menu['icon']}} "></i> 
										{{__("admin.$label")}}
								</a>
							</li>
							@endforeach   
						@endif 
							
					</ul>
				 
					<ul class="nav pull-right">
						<li>
							<a href="{{action('core/user/edit',array('id'=>Auth::user()->id));}}"><i class="icon-user"></i> {{ Auth::user()->username;}}</a>
						</li>
						<li>
							<a href="{{action('core/logout/index')}}"><i class="icon-off"></i>{{__('admin.logout');}}</a>
						</li>
					</ul>
				   <ul class="nav pull-right" id="main-menu-right" style="margin-top: 10px;" title="">
		          @foreach($li as $k=>$v)
		          <li style='margin-right:5px;' class='hand'><span class="label li " style="background:{{$v}}" rel='{{Helper::get_url(array('theme'=>$k))}}'>&nbsp;</span></li>
		          @endforeach
		        </ul>
				</div>
			</div>
		</div>
	</div>
  	<div class="container">  
		<div class="subnav subnav-fixed">
		    <ul class="nav nav-pills ">
		      <?php 
		       
			  if($rows){ foreach($rows as $row){
			  	    unset($active);
			  	   	if(is_array(Menu::get_active()) && in_array($row->value,Menu::get_active())){
						$active="class='active'";
					}
					if($row->lock==1){
				 		if(Auth::user()->id!=1){
				 			continue;
				 		}
			 		}
			  
			?>
			  @if(CMS::check("node.".$row->value.".index"))
		      <li {{$active}}><a href="{{action('core/node/index',array('name'=>$row->value))}}">{{$row->label}}</a></li>
		      @endif
		      <?php 
		       } }
			  ?> 
			   <?php
		 		  $i18n = array(
		 		  		'zh'=>'简体中文',
		 		  		'en'=>'English',
		 		  );
		 		  foreach($i18n as $k=>$v){
		 		?>
				<li style='float:right'>
					<a href="{{Helper::get_url(array('language'=>$k))}}"><img src="{{URL::base().'/misc/i18n/'.$k.'.gif'}}" title="{{$v}}">  </a>
				</li>
				<?php }?>
		    </ul>
		     
		 </div>	
		
		 
	 </div>	
	<div class="container" id="main">   
		 		  
			@if(CMS::get('navigation')) 
			<blockquote><p><h3>{{CMS::get('navigation');}}</h3></p></blockquote>  	<div class="flash_message"> </div>
				<div id='revision'  ></div>
			<hr>
			@endif
				
			@yield('content') 
			<div style="height:50px;"></div> 
	</div> 
	<div id='update' class='fixed_message_main' style='display:none;' ></div>
	 <footer class="footer">
	    <div class="container">
	        <p class="powered">
			 Powered by 裴祖荫太极拳<br> 
	        </p><p class="copy">Copyright © 2013-{{date('Y')}} by <a href="http://www.ljftaichi.com" target='_blank'>裴祖荫太极拳</a> </p>
	    </div>
	</footer>
{{ CMS::render();}} 
{{ Asset::styles();}}
{{ Asset::scripts();}} 
</body>
</html>