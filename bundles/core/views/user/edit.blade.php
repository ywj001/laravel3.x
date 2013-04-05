@layout('core::layout') 
@section('content')  
<?php
CMS::script('fouce',"
	$('#old_password').focus();
	if($('#old_password').val()){
		$('#password').focus();
	}
	if($('#password').val()){
		$('#password_confirmation').focus();
	}
	");
?>
</script>
		 <div class=" ">
	        <legend>{{__('admin.user edit')}} #{{$user->id}}
</legend>
	        {{Form::open();}} {{Form::token();}} 
	        	<input class="span3"   type="text"   name="username" value="{{$user->username}}" readonly='readonly'>  
	            <p> <blockquote>{{__('admin.username')}}</blockquote>
		            <input class="span3" placeholder="{{__('admin.old password')}}" value="{{Input::get('old_password');}}"  type="password" id="old_password" name="old_password">  
					@if($validation)
		            	{{$validation->first('old_password',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	            <p><blockquote>{{__('admin.password')}}</blockquote>
		            <input class="span3" placeholder="{{__('admin.new password')}}" value="{{Input::get('password');}}" type="password" id="password" name="password">  
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
		            @if($error)
		             <p class='alert alert-error'>{{__('admin.old password incorrect')}}</p> 
		            @endif  
	            </p>	
	            
	            <p><blockquote>{{__('admin.email')}}<span class='label label-info'>{{__('admin.find password')}}</span></blockquote>
		            <input class="span3" placeholder="{{__('admin.find password')}}" value="@if(Input::get('email'))
{{Input::get('email')}}
@else
{{$user->email}}@endif" type="text" id="email" name="email">  
					@if($validation)
		            	{{$validation->first('email',"<p class='alert alert-error'>:message</p>")}}
		            @endif
 	            </p>     
	            	        	
	             
	            <button class="btn-info btn" type="submit">{{__('admin.save')}}</button>      
		     {{Form::close();}}
	      </div>
		 
 					
@endsection