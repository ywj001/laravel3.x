@layout('core::layout')  
@section('content')
<?php //icon-refresh?> 
{{Form::open(null,null,array('id'=>'httpimage'))}}
 	<input type='url' id='url' name='url' style='width:500px;' required="true"  >
 	<br>
 	{{__('admin.width')}}:<input type='text' id='width' name='width' style='width:50px;' required="true" value="100" >
 	{{__('admin.height')}}:<input type='text' id='height' name='height' style='width:50px;' required="true" value="100" >
 	<br>
 	<button type='submit' class="btn ajax-load" href="#" > 
 		<i class=" icon-spin ajax-loading"></i> 
 		<span>{{__('admin.get images')}}</span>
 	</button>
  			
{{Form::close()}}
<br>
<div id="httpimage_page"></div>	
<?php 
CMS::style('httpimage',"
#httpimage_page .item {
  width: 220px;
  margin-right: 10px;
  margin-bottom: 10px;
  float: left;
  position: relative;
}
#httpimage_page .item span{
position: absolute;
top: 0; 
cursor:pointer; 
}
#httpimage_page .item img{ 
  float: left;
}
.httpimg{ 
background: #e64531;
color: #fff;
padding: 3px;
position: absolute;
right: 0;
width: 64px;
}
.httpimg2{ 
background: #005580;
color: #fff;
padding: 3px;
position: absolute;
left: 0;
width: 34px;
}
");
CMS::script('httpimage',"   
	$('#url').focus(); 
	$('#httpimage').submit(function() {  
		$('#httpimage .ajax-loading').addClass('icon-refresh');
		$('.ajax-load span').attr('style','color:#005580;'); 
		$('#httpimage .ajax-load span').html('".__('admin.loading……')."');  
		$('#httpimage_page').html('')
		$.post('".action('httpimage/home/get')."', {url:encodeURIComponent($('#url').val()),width:$('#width').val(),height:$('#height').val(), },function(data){
			$('#httpimage .ajax-loading').removeClass('icon-refresh');
			$('#httpimage .ajax-load').removeAttr('disabled');
			$('#httpimage .ajax-load span').html('".__('admin.get images')."'); 			
			$('#httpimage_page').html(data); 
			$('#httpimage_page').masonry({itemSelector:'.item' }); 
		    $('.ajax-load span').removeAttr('style'); 
			$('#httpimage_page .ajax').click(function(){
				var obj = this;
				$.post('".action('httpimage/home/load')."',{ url:$(this).attr('rel')},function(data){ 
					$(obj).parent().append(\"<span class='httpimg' style='width: 95px;' >".__('admin.download success')."</span>\");
					$(obj).remove();
				}); 
			});
		}).fail(function() {
			$('#httpimage .ajax-loading').removeClass('icon-refresh');
			$('#httpimage .ajax-load').removeAttr('disabled');
			$('#httpimage .ajax-load span').html('".__('admin.get images')."'); 
			$('#httpimage_page').html('<div class=\"alert alert-error\">".__('admin.http request error')."</div>');  
		
		}); 
		
	    return false; 
	});
	 
	 
");
?>	
@endsection