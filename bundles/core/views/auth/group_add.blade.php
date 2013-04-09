@layout('core::layout') 
@section('content')  
<?php
plugin('select2');
?> 
		 <div class="" id='auth'> 
	        {{Form::open();}} {{Form::token();}}    
	            <p>
	            	<blockquote><span class='label label-info'>{{__('admin.group name')}}</span></blockquote>
		            <input class="span3"   type="text"  id='title' name="title" value="@if($post && !$_POST)
{{$post->title}}@else{{Input::get('title')}}@endif
">  
					@if($validation)
		            	{{$validation->first('title',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	            <p>
	            	<blockquote><span class='label label-info'>{{__('admin.group user')}}</span></blockquote>
		            {{Form::select('users[]',$users,$user,array('style'=>'width:500px;','multiple'=>'multiple'))}}
	            </p> 
	            <p>
	            	<blockquote><span class='label label-info'>{{__('admin.group access')}}</span></blockquote>
	            	<div style='margin-left:20px;'>
	            		@if(CMS::access_list())
			            @foreach(CMS::access_list() as $k=>$v)
			            	<blockquote ><span class='label label-info'>{{__("admin.$k")}}</span></blockquote>
				            	<div style='margin-left:50px; clear:both;margin-bottom:20px;'>
				            	 
				            	<?php if(!$v) continue;?>
				            	 
				            	@foreach($v as $key=>$val)
				            		@if(!is_array($val))
				            			<span class='hand label @if($post && $post->access[$k][$val]) label-success @endif' style='margin-right:10px;margin-bottom:10px;'>
				            				<input style='display:none' type='checkbox'  @if($post && $post->access[$k][$val]) checked='checked' @endif  value="1" name="access[{{$k}}][{{$val}}]"> 
				            				{{__("admin.$val")}}
				            			</span>
				            		@else
					            		  @if(is_array($val))
						            			@foreach($val as $_k=>$_v)
						            				@if(is_array($_v))
						            				<div style=' margin-bottom:20px;'>
						            				<blockquote>{{__("admin.$_k")}}</blockquote>  
						            				@foreach($_v as $n=>$vo)
						            				<span class='hand label @if($post && $post->access[$k][$key][$vo]) label-success @endif' style='margin-right:10px;'>
							            				<input style='display:none' type='checkbox' @if($post && $post->access[$k][$key][$vo]) checked='checked' @endif value="1" name="access[{{$k}}][{{$key}}][{{$vo}}]"> 
							            				{{__("admin.$vo")}}
							            			</span>
						            	 			@endforeach
						            	 			</div>
						            	 			@endif	 
						            			@endforeach
					            			@endif	 
				            		@endif
				            	@endforeach
				            	</div>
			            @endforeach
			            @endif
		            </div>
	            </p>
	            <p>
	            	<blockquote>{{__('admin.group memo')}}</blockquote>
		            {{Form::textarea('memo',$post->memo,array('style'=>'height:30px'))}}
	            </p>  
		     {{Form::close();}}
	      </div>
	<?php
	CMS::script('core_auth_group',"
		 function submit(){
		 	$('form').ajaxSubmit({  
		        target: '#update',
		        url: '".action('core/auth/group_add/'.$id)."',     
				type: 'post',  
		        success: function(data) { 
		        	if(data==1){
		        		data = '".__('admin.success')."';
		        	}   
		            $('#update').html(data).fadeIn('slow') 
		            	.animate({opacity: 1.0}, 1000).fadeOut('slow');
		        } 
		    });  
		 }
		 $('select[name=\"users[]\"]').change(function(){ 
		 	submit();
		 });
		  $('#auth').find('span.label').click(function(){
		  	 var arr=$(this).find('input');
		  	 if(!arr.attr('checked')){
		  	 	 arr.attr('checked','checked');
		  	 	 $(this).addClass('label-success');
			 }
		  	 else{
		  	 	 arr.removeAttr('checked');
		  	 	 $(this).removeClass('label-success');
			 }
			 submit();
			
		     
		  });
	");		  
	?>	 
 					
@endsection