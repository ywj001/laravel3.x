@layout('core::layout')
@section('title2') 
{{__('admin.user list')}} 
@endsection

@section('content') 
<div class="row-fluid">  
	<div class="span12 m-widget"> 
		<div class="m-widget-body">
			<table class="table table-bordered  table-hover ">
				<thead>
					<tr> 
						<th>ID</th>
						<th>{{__('admin.username')}}</th>
						<th style="width:50px;">{{__('admin.actions')}}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users->results  as $user)	
					<tr> 
						<td>{{$user->id}}</td>
						<td>{{$user->username}}</td>
						<td class="tr">
							<div style="float:right;">
							<a style='margin-right:10px;' href="{{action('core/user/edit',array('id'=>$user->id));}}" ><i class='icon-pencil'></i></a> 
							@if($user->display==1) 
							<a title="{{__('admin.enabled')}}" href="{{action('core/user/del',array('id'=>$user->id));}}"  ><i class="icon-ok"></i></a>
							@else
							<a title="{{__('admin.disabled')}}"href="{{action('core/user/del',array('id'=>$user->id));}}"  ><i class="icon-ban-circle" style="color: red;"></i></a>
							@endif
							
								 
							</div>
						</td>
					</tr>
				    @endforeach
				</tbody>
			</table>
			
			
		</div>
	  </div>
</div>	
{{$users->links();}}
<br><a href="{{action('core/user/add')}}" class="btn">
	<i class="icon-plus"></i> <strong>{{__('admin.create user')}}</strong>
</a>
						
@endsection