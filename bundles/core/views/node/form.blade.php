@layout('core::layout') 
@section('content')  
	{{ \Plugins\Select2\Init::view();}}
	@if($vid>0)
		<blockquote><span class='badge badge-warning'>{{__('admin.revision is')}} <strong>{{(int)base64_decode($_GET['_revision'])}}</strong>  </span></blockquote>
	
	@endif
	
	{{Form::open_for_files(null,null,array('id'=>'node_form'));}}	  
		@if($one)
			<input type='hidden' name='id' value="{{encode($nid)}}">
		@endif 
		@foreach($fields as $f) 
		<?php 
			if($f['lock']==1) continue;
			$_flag = false;
			$v = $f['value'];  
			$value = $one->$v; 
			if(true===CMS::check_coloum("field_exclude.$name.$v")) continue;
		?>
		<p>
		 
			<blockquote>{{Form::label($f['value'],__("admin.".$f['label']),array('class'=>'') )}} </blockquote>
			 <?php
			 if($f['plugins']){
			 	foreach($f['plugins'] as $mk=>$mv){ 
			 		$op = array('tag'=>'#'.$f['value']); 
			 		if($mv['more'])
			 		{
			 			$more = $mv['more'];
			 			unset($mv['more']);
			 		}
			 		if($mv)
			 			$op = array_merge($mv,$op); 
			 		if($more)
			 			$op = array_merge($more,$op); 
			 			 
			 		plugin($mk,$op);
			 	}
			 }	 
			 ?>
			{{Node::hook($name,$v,$value)}}
			<?php  
			switch($f['form']){
				case 'select':
				$_flag = true;
			?> 		 
				    <select id = "node_{{$f['value']}}" @if($f['limit']>0) name="{{$f['value']}}[]"  multiple='multiple' @else name="{{$f['value']}}" @endif style='width:200px;'>
					 	{{ Helper::taxonomy_node_form($f['taxonomy']);}}
					</select>
					 <?php  
					 if($value){
					 	if(is_array($value)){
					 		foreach($value as $k=>$v ){
					 			$a .= $k.',';
					 		}
					 		$a  = "".substr($a,0,-1)."";
					 	}else{
					 		$a = "$value]";
					 	}
					 }
					   
					 CMS::script("form_node_{$f['value']}","
					 	var myArray = '[".$a."]';  
					 	$('#".'node_'.$f['value']." option').each(function(){  
					 		if(myArray.indexOf($(this).val())!=-1){  
					 			$(this).attr('selected','selected');
					 			$('select').select2();
					 		}
					 	});
					 ");	 
				 ?>
					 	 
			<?php			 
					break;
					case 'checkbox':
						$_flag = true; 
						$trows = Helper::taxonomy_items($f['taxonomy']);
						if(!$trows) return; 
						foreach($trows as $ro)
							echo Form::checkbox($f['value'].'[]',$ro->id,$value[$ro->id]).'&nbsp;'. $ro->name.'&nbsp;';
						break;
					case 'radiobox':
						$_flag = true; 
						$trows = Helper::taxonomy_items($f['taxonomy']);
						if(!$trows) return; 
						foreach($trows as $ro)
							echo Form::radio($f['value'],$ro->id,$value[$ro->id]).'&nbsp;'. $ro->name.'&nbsp;';
						break;	
					case 'file':
						$_flag = true; 
						?>
							@render('core::node.upload',array('f'=>$f,'ro'=>$ro,'one'=>$one))
			<?php 
						break;
			}
			?>
			 
			@if(false === $_flag && !is_array($f['form']))  
				{{Form::$f['form']($f['value'],$one->$f['value']);}}
			@endif
			{{Helper::form($f['form'],$f['value'],$one->$f['value'])}}
			@if($f['tips'])
				<span class='label label-info' style='vertical-align: top;'>{{$f['tips']}}</span>
			@endif
				
			
		</p>
		@endforeach
		<button type="submit" class="btn btn-info">{{__('admin.save')}}</button>
				
		<a style="margin-left:10px;" href="{{action('core/node/index',array('name'=>$name));}}" class="btn">
        	  <strong>{{__('admin.back')}}</strong>
        </a>  
	{{Form::close();}} 
	<?php   
	if($nid){
		\CMS::script('node_revision',"  
		$.post('".action('core/node/revision')."',{fid:".$type_id.",nid:".$nid."},function(data){
			if(data==1) return false;
			$('#revision').html(data);
		});");
	}
	\CMS::script('node_edit',"   
	
	function iconremove(){
		$('#node_form .file .icon-remove').click(function(){
			$(this).parent('div.file:first').remove();
		});
	}
	iconremove();
	$('form').ajaxForm({ 
        target: '#update', 
		type: 'post', 
		beforeSend: function(arr) { 
		    $('button[type=\"submit\"]').attr('disabled','disabled');
		},
        success: function(data) { 
        	if(data==1){  
        		window.location =  '".action('core/node/index',array('name'=>$name)).Helper::get('revision')."';
        		return false;
        	}else{
        		$('button[type=\"submit\"]').removeAttr('disabled');
        	}
            $('#update').css('color','#b94a48').fadeIn('slow') 
            	.animate({opacity: 1.0}, 1000).fadeOut('slow');
        } 
    });  

	");


?>


@endsection