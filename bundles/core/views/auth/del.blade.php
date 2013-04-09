@layout('core::layout')
@section('title2') 
{{__('admin.confirm delete')}} 
@endsection

@section('content') 
	<div class="text-warning">
		<h2>{{__('admin.confirm delete current user group')}}:</h2>
		 
		<h2>{{$group->title;}}</h2>
	</div>
	<div class='alert alert-warning' style='width:301px'>
		{{__('admin.this option can not go back,please confirm again')}} 
	</div>
	{{Form::open(null,null,array('style'=>'float:left;'));}}
	<input type='hidden' name='delete' value=1>
 	<button href="#" class="btn btn-danger"><i class="icon-trash icon-large"></i> <strong>{{__('admin.delete')}}</strong></button>
 	{{Form::close();}}
 	&nbsp;&nbsp;
 	<a style="margin-left:10px;" href="{{action('core/auth/index');}}" class="btn"><i class="icon-remove-sign icon-large"></i> <strong>{{__('admin.cancel')}}</strong></a>				
@endsection