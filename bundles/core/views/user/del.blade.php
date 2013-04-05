@layout('core::layout')
@section('title2') 
{{__('admin.confirm delete')}} 
@endsection

@section('content') 
	<div class="text-warning">
		<blockquote><h3>{{$user->username;}}</h3></blockquote>
		<h2>{{__('admin.change current user status')}}:</h2>
		 
		
	</div>
	 
	{{Form::open(null,null,array('style'=>'float:left;'));}}
	<input type='hidden' name='delete' value=1>
 	<button href="#" class="btn btn-info "><strong>{{__('admin.run')}}</strong></button>
 	{{Form::close();}}
 	&nbsp;&nbsp;
 	<a style="margin-left:10px;" href="{{action('core/user/cancel');}}" class="btn"> <strong>{{__('admin.cancel')}}</strong></a>				
@endsection