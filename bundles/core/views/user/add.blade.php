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
	        
	        {{Form::open();}} {{Form::token();}} 
	        	
	            <p><blockquote>{{__('admin.username')}}</blockquote>
		            <input class="span3"   type="text"   placeholder="{{__('admin.username')}}" id='username' name="username" value="{{Input::get('username')}}">  
					@if($validation)
		            	{{$validation->first('username',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	            <p><blockquote>{{__('admin.password')}}</blockquote>
		            <input class="span3" placeholder="{{__('admin.password')}}" value="{{Input::get('password');}}" type="password" id="password" name="password">  
					@if($validation)
		            	{{$validation->first('password',"<p class='alert alert-error'>:message</p>")}}
		            @endif   
	            </p>
	            <p>
		            <blockquote>{{__('admin.password_confirmation')}}</blockquote>
		            <input class="span3" placeholder="{{__('admin.password_confirmation')}}" value="{{Input::get('password_confirmation');}}" type="password" id="password_confirmation" name="password_confirmation"> 
		            @if($validation)
		            	{{$validation->first('password_confirmation',"<p class='alert alert-error'>:message</p>")}}
		            @endif
	            </p>
	           	<p><blockquote>{{__('admin.email')}}<span class='label label-info'>{{__('admin.find password')}}</span></blockquote>
		            <input class="span3" placeholder="{{__('admin.find password')}}" value="{{Input::get('email');}}" type="text" id="email" name="email">  
 	            	@if($validation)
		            	{{$validation->first('email',"<p class='alert alert-error'>:message</p>")}}
		            @endif
 	            </p>       	
	            
	            <button class="btn-info btn" type="submit">{{__('admin.create user')}}</button>      
		     {{Form::close();}}
	      </div>
		 
 					
@endsection