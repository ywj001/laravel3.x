@layout('core::layout')
@section('title2') 
{{__('admin.content type')}} 
@endsection 
@section('content') 
<div class="row-fluid">  
	<div class="span12 m-widget"> 
		<div class="m-widget-body">
			<table class="table table-bordered  table-hover ">
				<thead>
					<tr> 
						<th>{{__('admin.module name')}}</th>
						<th>{{__('admin.discription')}}</th>
						<th>{{__('admin.author')}}</th>
						<th style="width:90px;">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					@foreach($post  as $p)	
					<tr> 
						<td>{{$p['name'];}}</td>
						<td>{{$p['info']['memo'];}} </td>
						<td>{{$p['info']['auth'];}} </td>
						<td>
							<div style='float:right;'>
							@if(in_array($p['name'],$modules)) 
							<a title="{{__('admin.enabled module')}}" href="{{action('core/module/able',array('name'=>$p['name']));}}" class="btn btn-success"><i class="icon-ok"></i> <strong>{{__('admin.enabled')}}</strong></a>
							@else
							<a title="{{__('admin.disabled module')}}"href="{{action('core/module/able',array('name'=>$p['name']));}}" class="btn btn-danger"><i class="icon-ban-circle"></i> <strong>{{__('admin.disabled')}}</strong></a>
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
 						
@endsection