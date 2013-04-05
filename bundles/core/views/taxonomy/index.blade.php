@layout('core::layout')
@section('title2') 
{{__('admin.content type')}} 
@endsection

@section('content')  
	{{Form::open(null,null,array('id'=>'taxonomy'))}} 	
	<table class="table table-bordered  table-hover ">
		<thead>
			<tr> 
				<th>{{__('admin.taxonomy name')}} 
				@if(isset($top))
					<a href="{{action('core/taxonomy/index',array('taxonomy_id'=>$_GET['back_taxonomy_id']))}}"><span class='icon-arrow-left '></span></a>
				@endif
				</th> 
				<th style="width: 120px;"> {{__('admin.actions');}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($taxonomy  as $t)	
			<tr> 
				<td>
				<i class="icon-move"></i><input type='hidden' name='ids[]' value="{{$t->id}}">
				@if(Helper::taxonomy_has_item($t->id))
					<a href="{{action('core/taxonomy/index',array('taxonomy_id'=>$t->id));}}">
					{{$t->name}}
					</a>
				@else
					{{$t->name}}
				@endif
				</td> 
				<td class="tr">
					<div style="float:right;"> 
					<a href="{{action('core/taxonomy/edit',array('id'=>$t->id));}}" class="btn"><i class="icon-edit"></i> <strong>{{__('admin.edit')}}</strong></a>
					@if($t->display==1) 
					<a title="{{__('admin.enabled')}}" href="{{action('core/taxonomy/del',array('id'=>$t->id)).Helper::get();}}" class="btn btn-success"><i class="icon-ok"></i> <strong> </strong></a>
					@else
					<a title="{{__('admin.disabled')}}"href="{{action('core/taxonomy/del',array('id'=>$t->id)).Helper::get();}}" class="btn btn-danger"><i class="icon-ban-circle"></i> <strong> </strong></a>
					@endif
				
					</div>
				</td>
			</tr>
		    @endforeach
		</tbody>
	</table>
	{{Form::close();}}
	 
<br><a href="{{action('core/taxonomy/add').Helper::get()}}" class="btn">
	 <strong>{{__('admin.create taxonomy')}}</strong>
</a>
<?php 
$taxonomy_id = $_GET['taxonomy_id']?:0;
 
 
	Helper::ui_sort('#taxonomy',action('core/taxonomy/sort',array('id'=>$taxonomy_id)));
 	
?>						
@endsection