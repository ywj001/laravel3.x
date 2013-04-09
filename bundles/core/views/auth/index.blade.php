@layout('core::layout')
@section('title2') 
{{__('admin.user list')}} 
@endsection

@section('content') 
 
<blockquote><h3>{{__('admin.user group')}}</h3></blockquote>	
@if($groups)
<div class="row-fluid">   
	<div class="span12 m-widget"> 
		<div class="m-widget-body">
			<table class="table table-bordered  table-hover ">
				<thead>
					<tr> 
						<th>{{__('admin.group name')}}</th>
						<th>{{__('admin.user')}}</th>
						<th style="width:50px;"> </th>
					</tr>
				</thead>
				<tbody>
					@foreach($groups  as $g)	
					<tr> 
						<td>{{$g->title}}</td>
						<td><?php
						$users = DB::table('user_group')->where('gid','=',$g->id)->get();	
						if($users){
							foreach($users as $u){
								$uids[] = $u->uid;
							}
							$users = DB::table('users')->where_in('id',$uids)->get();	
							if($users){
								foreach($users as $li){
									echo "<span class='label label-info' style='margin-right:5px;' title='mail:".$li->email."'>".$li->username."</span>";
								}
							}
						}	
						?></td>
						<td class="tr">
							<div style="float:right;">
								<a href="{{action('core/auth/group_add',array('id'=>$g->id));}}"  >
									<i class="icon-edit"></i> </a>
								&nbsp;
								<a href="{{action('core/auth/remove',array('id'=>$g->id));}}"  >
									<i class="icon-remove"></i> </a> 
							</div>
						</td>
					</tr>
				    @endforeach
				</tbody>
			</table>
			
			
		</div>
	  </div>
</div>	
@endif		
<p>
	<a href="{{action('core/auth/group_add')}}" class="btn">
		<i class="icon-plus"></i> <strong>{{__('admin.create user group')}}</strong>
	</a>
</p>
						
@endsection