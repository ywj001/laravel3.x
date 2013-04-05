@layout('core::none') 

@section('content') 
	<div class="text-warning">
		<h2>{{__('admin.confirm delete')}}</h2> 
		<h2>{{$post->label;}}@if($post->value)
			[{{$post->value;}}]
			@endif
		</h2>
	</div>
	<div class='alert alert-warning' style='width:301px'>
		{{__('admin.this option can not go back,please confirm again')}} 
	</div>
	{{Form::open(null,null,array('style'=>'float:left;'));}}
	<input type='hidden' name='delete' value=1>
 	<button href="#" class="btn btn-danger">
 		<i class="icon-trash icon-large"></i> <strong>{{__('admin.delete')}}</strong>
 	</button>
 	&nbsp;&nbsp;
 	<a style="margin-left:10px;" 
 		href="{{action('core/type/fileds',array('id'=>$pid));}}" class="btn">
 		<i class="icon-remove-sign icon-large"></i> <strong>{{__('admin.cancel')}}</strong></a>				
 	{{Form::close();}} 
@endsection