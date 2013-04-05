@layout('core::layout') 
@section('content')  
<?php
CMS::script('fouce',"
	$('#username').focus();
	if($('#username').val()){
		$('#password').focus();
	}
	if($('#password').val()){
		$('#password_confirmation').focus();
	}
	");
?>
		 <div class=" ">
	        <legend>{{__('admin.create content type')}} </legend>
	        {{Form::open();}} {{Form::token();}}  
	            <p>
		            <input class="span3"   type="text"   placeholder="{{__('admin.label')}}" id='label' name="label" value="{{Input::get('label')}}">  
					@if($validation)
		            	{{$validation->first('label',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	            <p>
		            <input class="span3"   type="text"   placeholder="{{__('admin.filed name')}}" id='value' name="value" value="{{Input::get('value')}}">  
					@if($validation)
		            	{{$validation->first('value',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	            <p> <blockquote>{{__('admin.lock')}}</blockquote>
	            {{Form::select('lock',array(0=>__('admin.no'),1=>__('admin.yes')),$post->lock)}}
	            </p>
	            <p> <blockquote>{{__('admin.not admin')}}</blockquote>
	            {{Form::select('admin',array(0=>__('admin.no'),1=>__('admin.yes')),$post->admin)}}
	            </p>       	
	            <br>
	            <button class="btn-info btn" type="submit">{{__('admin.create content type')}}</button>    
	            <a style="margin-left:10px;" href="{{action('core/type/index');}}" class="btn">
	            	<i class="icon-remove-sign icon-large"></i> <strong>{{__('admin.back')}}</strong>
	            </a>  
		     {{Form::close();}}
	      </div>
		 
 					
@endsection