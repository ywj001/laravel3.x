@layout('core::layout')
@section('title2') 
{{__('admin.fileds')}} 
@endsection

@section('content') 
<blockquote><p> {{$post->label}}  </p></blockquote>	
@if($posts) 
<div class="row-fluid">  
	<div class="span12 m-widget">
		{{Form::open(null,null,array('id'=>'field_sort'))}} 
		<div   class="m-widget-body ">
			<table class="table table-bordered  table-hover">
				<thead>
					<tr> 
						<th>{{__('admin.label')}}</th>
						<th>{{__('admin.filed name')}}</th>
						<th style="width:50px;">{{__('admin.actions')}}</th>
					</tr>
				</thead>
				<tbody> 
					@foreach($posts  as $user)	
					<tr> 
						<td><input type='hidden' name='ids[]' value="{{$user->id}}">{{$user->label}}</td>
						<td>{{$user->value}}</td>
						<td class="tr">
							<div style="float:right;">
							<a class='fancybox fancybox.ajax' href="{{action('core/type/edit_field',array('id'=>$user->id))}}"   >
							<i class="icon-edit"></i> </a> &nbsp;
							<a class='fancybox fancybox.ajax' href="{{action('core/type/del_field',array('id'=>$user->id))}}" >
								<i class="icon-trash"></i>
							</a>
							</div>
						</td>
					</tr>
				    @endforeach 
				</tbody>
			</table> 
		</div>
		{{Form::close();}}
	  </div> 
</div>	
@else
	<div class='alert alert-error'>{{__('admin.please add fileds');}}</div>
@endif
<br> 
<a class='btn fancybox fancybox.ajax' href="{{action('core/type/add_field',array('id'=>$id))}}"  >{{__('admin.add filed')}}</a>	
			
<?php 
	CMS::style('field_sort',"#field_sort tbody span { position: absolute; margin-left: -1.3em; }");
	 
	Helper::ui_sort('#field_sort',action('core/type/field_sort',array('id'=>$id)));
	?>					
@endsection
