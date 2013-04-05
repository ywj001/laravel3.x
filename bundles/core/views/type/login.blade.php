<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin</title>
{{ HTML::style('misc/bootstrap/css/bootstrap.min.css');}} 
{{ HTML::script('js/jquery.min.js'); }}
{{ HTML::script('js/jquery.form.js'); }}   
{{ Asset::styles();}}
{{ Asset::scripts();}} 
<script>
$(function(){
	$('#username').focus();
	if($('#username').val()){
		$('#password').focus();
	}
});
</script>
</head>
<body >
 	
    <div style="width: 400px;margin-top: -200px;margin-left: -200px;position: absolute;	left: 50%;top: 50%;">
    @if(\Session::has('success'))
	<div class="alert alert-info"> 
		{{\Session::get('success');}}
	</div>
	@endif
      <div class="well">
        <legend>{{__('admin.sign in')}}</legend>
        {{Form::open();}} {{Form::token();}} 
            <input class="span3" placeholder="{{__('admin.username')}}" value="{{Input::get('username');}}" type="text" id="username" name="username"> 
            @if($validation)
            	{{$validation->first('username',"<p class='alert alert-error'>:message</p>")}}
            @endif
            <input class="span3" placeholder="{{__('admin.password')}}" type="password" id="password" name="password">  
			@if($validation)
            	{{$validation->first('password',"<p class='alert alert-error'>:message</p>")}}
            @endif   
            @if($error)
             <p class='alert alert-error'>{{__('admin.login failed')}}</p> 
            @endif          	
            <br>
            <button class="btn-info btn" type="submit">{{__('admin.login')}}</button>      
	     {{Form::close();}}
      </div>
    </div>
 
</body>
</html>