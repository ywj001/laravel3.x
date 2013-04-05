@layout('core::layout')
@section('title2') 
{{__('admin.content type')}} 
@endsection

@section('content') 
<div class="row-fluid">  
	<div class="span12 m-widget"> 
		<div class="m-widget-body">
			{{Form::open(null,null,array('id'=>'sort'))}} 	
			<table  class="table table-bordered  table-hover ">
				<thead>
					<tr> 
						<th>{{__('admin.label')}}</th>
						<th>{{__('admin.filed name')}}</th>
						<th style="width:210px;">{{__('admin.actions')}}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($posts->results  as $user)	
					<tr> 
						<td> <i class="icon-move"></i>&nbsp;<input type='hidden' name='ids[]' value="{{$user->id}}">{{$user->label}}</td>
						<td>{{$user->value}}</td>
						<td class="tr">
							<div style="float:right;">
							<a href="{{action('core/type/fileds',array('id'=>$user->id));}}" class="btn"> <strong>{{__('admin.fileds')}}</strong></a>
							<a href="{{action('core/type/edit',array('id'=>$user->id));}}" class="btn"><i class="icon-edit"></i> <strong>{{__('admin.edit')}}</strong></a>
							<a href="{{action('core/type/del',array('id'=>$user->id));}}" class="btn"><i class="icon-trash"></i> <strong>{{__('admin.delete')}}</strong></a>
							</div>
						</td>
					</tr>
				    @endforeach
				</tbody>
			</table>
			{{Form::close()}}
			
		</div>
	  </div>
</div>	
{{$posts->links();}}
<br><a href="{{action('core/type/add')}}" class="btn">
	<i class="icon-plus"></i> <strong>{{__('admin.create content type')}}</strong>
</a> 
{{Helper::ui_sort('#sort',action('core/type/sort'));}}
@endsection