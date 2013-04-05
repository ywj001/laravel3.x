@layout('core::layout') 

@section('content')  
 	<?php 
 	$showf['id'] = array('value'=>'id','label'=>'ID');
 
 	$showf = array_merge($showf,$fields);	
 	if($type->admin!=1)
 		$showf['uid'] = array('value'=>'uid','label'=>__('admin.user'));
 	$oo = $coloums; 
 	?> 
	@foreach ($showf as $f)
		<?php $new[] = $f['value'];?>
	 
	@endforeach 
	<?php 
		foreach($new as $n){
			if($coloums[$n])
				$display_coloums[$n] = true;
		}	
		$coloums = $display_coloums;
	?>
 	@if(Auth::user()->id==1)
		<p style="clear:both;">
				<span class='btn btn-info' id='show_set_coloumn'>{{__('admin.set display coloumn')}}</span> 
		</p>
		
	 	<div id='node_set' class='hide'  >  
	 	<?php 
	 	//$showf['id'] = array('value'=>'id');
	 	$showf = array_merge($showf,$fields);	 
	 	$oo = $coloums; 
	 	?>
	 	<ul>
		@foreach ($showf as $f) 
			<li href="{{action('core/node/set',array('name'=>$name,'field'=>$f['value']));}}" class="click hand alert  @if(is_array($coloums) && array_key_exists($f['value'],$coloums))alert-success @else alert-error @endif">
	 				@if(is_array($coloums) && array_key_exists($f['value'],$coloums))✔ @endif {{$f['label'];}} 
			</li> 
		@endforeach
		</ul>
	 
		</div>
	@endif
	<div  class='clear'> 
	{{Form::open(null,null,array('id'=>'node'))}}
		 <table class="table table-bordered  table-hover " > 
			<thead>
	                <tr> 
	                  <th class='node_list_th'>
	         		<a href="{{action('core/node/add',array('name'=>$name));}}"><i class="icon-plus-sign-alt add hand icon-2x"></i></a></th> 
	                  @if($coloums)
						@foreach($coloums as $k=>$v)
						<th > 
						  @if(strtolower($k)=='id') 
						  	ID
						  @else 
						  	{{__("admin.$k");}} 
						  @endif
						</th>
						@endforeach
					 @endif
					 <th style="width: 60px;"> {{__('admin.actions');}}</th>
	                </tr>
              </thead>
			<tbody> 
			   <?php $i=0;?>
			   @foreach ($posts->results as $post) 
				<tr class="@if($i++%2==0) even @else old @endif"> 
					<td class='node_list_th'>
						<i class="icon-move" ></i>
						<input type="hidden" name="id[]" value="{{$post->id}}"></td> 
					@if($coloums)
						@foreach($coloums as $k=>$v) 
						<td > @if(!is_array($post->$k)) 
						<?php 
						$value = node_restore($name,$k,$post->$k,$post);
						$v2 = node_restore_plugin($name,$fields,$k,$value,$post);
						if($v2) 
							echo $v2;
						else 
							echo $value;
						?> 
						@else  
						 	{{Helper::cck_value($post->$k)}}  
						@endif</td>
						@endforeach
					@endif
					<td>
						<div style="float:right;"> 
						<a style='margin-right:20px;' href="{{action('core/node/edit',array('id'=>$post->id,'name'=>$name)).Helper::get();}}" ><i class='icon-pencil'></i></a> 
					 	 
						@if($post->display==1) 
						<a title="{{__('admin.enabled')}}" href="{{action('core/node/del',array('id'=>$post->id,'name'=>$name)).Helper::get();}}"  ><i class="icon-ok"></i></a>
						@else
						<a title="{{__('admin.disabled')}}"href="{{action('core/node/del',array('id'=>$post->id,'name'=>$name)).Helper::get();}}"  ><i class="icon-ban-circle" style="color: red;"></i></a>
						@endif
						 
						
						</div>
					</td>
				</tr>
				@endforeach							
			</tbody>
		</table> 
		{{Form::close();}} 
		{{$posts->links();}} 
		
		 
		
	</div>
	
	
	 
	<?php 
	CMS::style('node_sort',"#node tbody span { position: absolute; margin-left: -1.3em; }");
	CMS::script(
	'node_sort', 
	"
	var   node_form_sort;
	$('li.click').click(function(){
		window.location = $(this).attr('href');
	});
	
	$('#show_set_coloumn').click(function(){
		if($('#node_set').css('display') == 'block')
			$('#node_set').hide();
		else
			$('#node_set').show();
	}); 
	"
	
	);
	
	Helper::ui_sort('#node',action('core/node/sort',array('name'=>$name)));	
	?>

@endsection