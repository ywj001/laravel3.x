@layout('core::layout') 
@section('content')  
<?php
CMS::script('fouce',"
	$('#label').focus();
 
	");
?>
</script>
		 <div class=" ">
	        <legend>{{__('admin.content type edit')}} #{{$post->id}}
</legend>
	        {{Form::open();}} {{Form::token();}} 
	        	
	            <p> <blockquote>{{__('admin.label')}}</blockquote>
		            <input class="span3" placeholder="{{__('admin.label')}}" value="{{$post->label;}}"  type="text" id="label" name="label">  
					@if($validation)
		            	{{$validation->first('label',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	            <p> <blockquote>{{__('admin.database table')}}</blockquote>
	            <input class="span3"   type="text"   name="value" value="{{$post->value}}" readonly='readonly'>          	
	            </p> 
	            <p> <blockquote>{{__('admin.lock')}}</blockquote>
	            {{Form::select('lock',array(0=>__('admin.no'),1=>__('admin.yes')),$post->lock)}}
	            </p>
	            <p> <blockquote>{{__('admin.not admin')}}</blockquote>
	            {{Form::select('admin',array(0=>__('admin.no'),1=>__('admin.yes')),$post->admin)}}
	            </p>
	            <button class="btn-info btn" type="submit">{{__('admin.edit')}}</button>   
	            <a style="margin-left:10px;" href="{{action('core/type/index');}}" class="btn">
	             <strong>{{__('admin.back')}}</strong>
	            </a>				
   
		     {{Form::close();}}
		     
	      </div>
		 
 					
@endsection