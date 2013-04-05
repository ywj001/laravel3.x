@layout('core::layout') 
@section('content') 
<div class='container-fluid'> 
		<div class='label label-warning'>{{__('admin.do not operate non-professionals')}}</div>

		 <table class="table table-bordered"> 
			<tr> 
				<th style='width:50px;'>#id</th> 
				<th>{{__('admin.name')}} </th>  
				<th style="width: 75px;"> {{__('admin.actions');}}</th>
			</tr>
			<tbody>
				@foreach ($posts->results as $row) 
				<tr>
					<td> {{$row->id}} </td> 
					<td>{{$row->name}}</td> 
					<td>
					<div style="float:right;"> 
					<a href="{{action('core/imagecache/admin',array('id'=>$row->id));}}" class="btn"><i class="icon-edit"></i> <strong>{{__('admin.edit')}}</strong></a>
				 
					</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table> 
	
   {{$posts->links();}}
{{Form::open();}} 
<button type="submit" class="btn btn-success">@if($id>0) 
	{{__('admin.save')}} 
	@else {{__('admin.create')}} 
	@endif</button>

@if($id>0) 
	<a href="{{action('core/imagecache/admin')}}" class="btn">{{__('admin.back')}}</a> 
@endif
<hr>
	<div class='row-fluid'>  
		<div class='span4'> 
			@if($id>0)
				<input name='id' type='hidden' value="{{$id}}">
			@endif
			<p>
				{{Form::label('label',__('admin.name'));}} 
				{{Form::text('name',$post->name?:"");}} 
			</p> 
		 	<p>
				<select id='action_name' name='action_name' style="width:200px" > 
					<option value="0"><?php echo __('admin.please select');?></option>
				 	@foreach($list as $v)
						<option value="{{$v}}" >{{__("admin.$v")}}</option>
					@endforeach 
				</select> 
				 <i class="icon-plus-sign-alt add hand icon-2x" style="margin-top: -4px;"></i>
			</p>
			<p>
				<div id='option'></div>	
			</p> 
			
			
		
		</div>
		<div class='span8'>
				<div id='clone'></div>	
		</div>
		{{Form::close();}}
	</div>
</div>
<?php 
plugin('masonry');
plugin('farbtastic');
$quality = 75;
if($id>0){
	$ops = unserialize($post->memo); 
	$quality = $ops['quality']?:$quality;
	if($ops){ 
		foreach($ops as $k=>$v){
			CMS::script('imagecache_id_'.$k,"
			$.post('".url('core/imagecache/ajax')."', { id: ".$id.",fid:'".$k."' },
				 function(data){  
				   	$('#clone').append(data);  
				   	after_ajax();
				 });
			");
		}
		//CMS::script("imagecache_ajax","after_ajax();");
	}
}
 
CMS::script('imagecache',"  
	
	function after_ajax(){ 
		var label;  
	    $('.add').click(function(){ 
	    	if($('form #option').html()){ 
	    		$('form #action_name option').each(function(){
					if($(this).attr('selected')){
						label = $(this).html();
						$(this).remove(); 
					}
				}); 
	    		$('#clone').append($('form #option').html()); 
				$('form #option').html('');
			}
		}); 
		effect();
		$('.icon-remove').click(function(){
			$(this).parent('div :first').remove(); 
		});
 	 	$('.water_form .title').click(function(){ 
	 		$('.new').hide();
	  		var j = $(this).parent().find('div.new:first');   
	 	 	j.show();
	 	 	 
	 	});
	 	
	 	
	}
	function effect(){
		var water_url = '".URL::base().'/'.$water_path."';
		if($('#farbtastic').length>0)
			jQuery.farbtastic('#farbtastic').linkTo('#bgcolor'); 
		if($('#farbtastic_border_color').length>0)
			jQuery.farbtastic('#farbtastic_border_color').linkTo('#border_color'); 
 		if($('#watermark_file').length>0){
			$('#watermark_file').change(function(){ 
				$('#watermark_show').html('<img src=\"'+water_url+$(this).val()+'\" />');
			});
	}
	 
		if($('#quality').length>0){
			$('#quality').css('width','25px');
			if(!$('#quality').val())
				$('#quality').val(80);
			$('div[rel=\"quality\"]').css('width','200px').slider({
		      range: 'max',
		      min: 1,
		      max: 100,
		      value: ".$quality.",
		      slide: function( event, ui ) { 
		        $('#quality').val( ui.value );
		      }
		    });
		}
	}
	  
	
	$('#action_name').change(function(){ 
		var val = $(this).val(); 
		if(val==0) return false;
		$.post('".url('core/imagecache/ajax')."', { id: ".$id.",fid:val },
		 function(data){  
		   	$('form #option').html(data); 
		   	after_ajax(); 
		   	
		 });
	});

");
?>		
@endsection