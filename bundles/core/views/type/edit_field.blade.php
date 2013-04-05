@layout('core::none') 

@section('content')  
{{Form::open(null,null,array('style'=> 'position:relative'))}}
<div style="width: 330px;float: left;" id='edit_field'>
	<p>
		<label>{{__('admin.label')}} </label>
		<input placeholder="" type='text' name='label' value="<?php if(!Input::get('label')){ echo $post->label;}else{ echo Input::get('label');} ?>" > 
	</p>
	<p>
		<label>{{__('admin.value')}} </label>
		<input type='text' name='value' value="{{$post->value}}" @if(true === $edit)
		readonly
		@endif
		> 
	</p>
	<p>
		<label>{{__('admin.form type')}} </label> 
		@if($table->id) 
		 	 <select class="column_type" name="old_type"  id='db_type'  disabled='disabled'>
		 	 	<option>{{$table->name}}</option>
		 	 </select>
		 @endif
		<?php unset($dis);if($table->id) $dis = "display:none;";?>
		{{Form::select('type',\Helper::cck(),$table->name,array('style'=>"width:100px;$dis "))}}
	</p>
	<div id='blongs_to'>
			 <?php 
			 $orm = $table->orm;
			 if($orm){
			 $orm = unserialize($orm);

			 ?>
			<input type="hidden" name="orm[type]" value="{{$orm['type']}}">
			<select name="orm[table]">
				<option value="{{$orm['table']}}">{{$orm['table']}}</option>
			</select>
			<select name="orm[field]">
				<option value="{{$orm['field']}}">{{$orm['field']}}</option>
			</select>
			<?php } ?>
	</div> 
	<p class='mysql' id='mysql'> 
		 <label>{{__('admin.db type')}} </label> 
		 @if($table->id) 
		 	 <select class="column_type" name="old"  id='db_type'  disabled='disabled'>
		 	 	<option>{{strtoupper($table->db_type);}}</option>
		 	 </select>
		 @endif
		 <select class="column_type" name="db_type" id="db_type" @if($table->id) style="display:none;" @endif>
				@foreach(\Helper::db_type() as $k=>$v)
				<option>{{$k}}</option>
			 	@endforeach
		</select>
		
	</p>
	<p id='form_length' class="multiple @if(!$table->taxonomy) hide @endif">
		<label>{{__('admin.allow multiple')}} </label>
		{{Form::select('length',array(0=>__('admin.no'),1=>__('admin.yes')),$table->length,array('style'=>'width:100px','id'=>'length'))}}
	 
	</p>
	<p  class="multiple @if(!$table->taxonomy) hide @endif">
		<label>{{__('admin.taxonomy')}} </label>
		<select name='taxonomy' id='taxonomy' style='width:200px;'>
    		{{$tree}}
    	</select>
	 
	</p>
	<p>
		<label>{{__('admin.hidden')}} </label>   
		{{Form::select('lock',array(0=>__('admin.no'),1=>__('admin.yes')),$post->lock)}}
	</p>	
	<p>
		<label>{{__('admin.tips')}} </label>   
		{{Form::text('tips',$post->tips)}}
	</p>
	
</div>
<div style="width: 250px;float: left;">		
	<p >
		<label>{{__('admin.validate')}} </label>
		{{Form::select('validate',\Helper::validation(),null,array('style'=>'width:180px'))}}		
		<i class="icon-plus-sign-alt add hand icon-2x" style="margin-top: -4px;"></i>
		<br>{{Form::input('text','validate_value');}}
	</p>
	 
	<div id='vali'>
		@if($validate)
			@foreach($validate as $v)
				<span class="tag" >
					<span>{{__("admin.$v->name");}} @if($v->value) {{$v->value}} @endif</span>
					<input type='hidden' value="{{$v->name.$v->value;}}" name='laravel[]'>
					<a href="#">x</a>
				</span> 
			@endforeach
		@endif
	</div>

	<span id='copy' class="tag" style='display:none;'>
		<span></span>
		<input type='hidden' value="" name='laravel[]'>
		<a href="#">x</a>
	</span>
		
	<p style='clear: both;'>
		<label>{{__('admin.plugins')}}   </label>
		<div id='plugin'></div>
		<div id='plugin_config'></div>
		<div id='plugin_lists'></div>	
		<?php  
		unset($form);
		if($plugins){
			$element = 'text';
		 
			foreach($plugins as $k=>$v){
				$form .="<div class='plugin  plugin_".$k."'><span class='remove-plugin icon icon-remove hand' style='float:right;'></span>";
				$form .= '<h3>'.$k.'</h3>';
				foreach($v as $key=>$val){ 
					if($key=='more'){
						$element = 'textarea'; 
						$val = Spyc::YAMLDump($val);
					}
					$form .= __('admin.'.$key).':'.Form::$element("plugins[$k][$key]",$val);
		 		}
		 		$_plugins .= $k.'::'; 
		 		$form .="</div>";
			}
			 
	 		echo $form;	 
 		}
 		 
 		?>
	</p>
</div>
	
		
	<div style='clear:both;'></div>
 	<button type='submit' class='btn' >{{__('admin.save')}}</button>
 	<div style='clear:both;'></div>	
{{Form::close()}} 

<?php  
	CMS::style('edit_field',"div.plugin{
	padding:10px;border:2px solid #ccc;
	margin-bottom:10px;
}
div.plugin textarea{height: 40px;}");
	if(false === $edit){
		$pid = $id;
		$url = action('core/type/add_field',array('id'=>$id));
	}else
		$url = action('core/type/edit_field',array('id'=>$id));
	\CMS::script('filed'," 
	function removePlugin(){
		$('.remove-plugin').click(function(){
			$(this).parent('div:first').remove();
		});
	}
	removePlugin();
	function load_plugin(){
		$.post('".action('core/type/plugin')."',{type:$('select[name=\"type\"] ').val(),p:'".$_plugins."'},function(data){
			$('#plugin').html(data);
			$('select[name=\"plugins\"] ').change(function(){  
				$.post('".action('core/type/plugin_config')."',{name:$(this).val()},function(data){ 
					$('#plugin_config').html(data);
					$('.add-plugin').click(function(){
						$('#plugin_lists').append('<span class=\"tag\">'+$('#plugin_config').html()+'</span>');
						$('#plugin_config').html('');
						var v = $('select[name=\"plugins\"] ').val();
						$('select[name=\"plugins\"] option').each(function(){
							if($(this).val()==v){
								$(this).remove();
							}
						});
					});
					removePlugin();
				});
			});
		});
	}
	load_plugin();
	var db_type = '".strtoupper($table->db_type)."';  
	var taxonomy = '".strtoupper($table->taxonomy)."';  
	var myArray = '[\"select\",\"checkbox\",\"radiobox\"]'; 
	var vArr = '[\"radiobox\",\"checkbox\"]'; 
	$('select[name=\"type\"]').change(function(){
		var v=$(this).val();
		var fl = false;
		if(v=='file' || v=='belongs_to'){
			fl = true;
			$('#db_type option').each(function(){ 
	 			if($(this).val()=='INT'){
	 				$(this).attr('selected','selected');
	 			}
	 		});
	 		$('#mysql').hide();
		} 
		if(v=='textarea'){
			fl = true;
			$('#db_type option').each(function(){ 
	 			if($(this).val()=='TEXT'){
	 				$(this).attr('selected','selected');
	 			}
	 		});
	 		$('#mysql').hide();
		}
		if(v=='text'){
			fl = true;
			$('#db_type option').each(function(){ 
	 			if($(this).val()=='VARCHAR'){
	 				$(this).attr('selected','selected');
	 			}
	 		});
	 		$('#mysql').show();
		}
		if(myArray.indexOf(v)!=-1){ 
			fl = true;
	 		$('.multiple').show();
	 		$('#db_type option').each(function(){ 
	 			if($(this).val()=='INT'){
	 				$(this).attr('selected','selected');
	 			}
	 		});
	 		if(vArr.indexOf(v)!=-1){ 
				$('#form_length').hide(); 		
			}else{
				$('#form_length').show();
			}
	 		$('#mysql').hide();
	 	}else{ 
	 		$('#length option,#taxonomy option').each(function(){
	 			if($(this).val()==0){
	 				$(this).attr('selected','selected');
	 			}
	 		});   
	 		$('.multiple').hide();
	 	}
	 	if(fl == false){
	 		$('#mysql').show();
	 	}
		 
	});
	
	$('select[name=\"taxonomy\"] option').each(function(){ 
		if($(this).val() == taxonomy){
			$(this).attr('selected','selected');
		}
	});
	$('select[name=\"type\"]').change(function(){ 
		if($(this).val() == 'belongs_to'){
			$.post('".action('core/type/has')."',{name:$(this).val()},function(data){
				$('#blongs_to').html(data);
				$('select[name=\"orm[table]\"]').change(function(){
					$.post('".action('core/type/has_field')."',{name:$(this).val()},function(data){
						$('select[name=\"orm[field]\"]').html(data);
					});
				});
			});
		}
	});
	
	
	$('select[name=\"db_type\"] option').each(function(){ 
		if($(this).val() == db_type){
			$(this).attr('selected','selected');
		}
	});
	$('input[name=\"validate_value\"]').hide();
	$('select[name=\"validate\"]').change(function(){
		var v=$(this).val();
		var ext =v.substr(v.length-1,v.length-1); 
		if(ext==':'){
			$('input[name=\"validate_value\"]').show();  
		}else{
			$('input[name=\"validate_value\"]').val('').hide();  
		}  
		 
	});
	$('select[name=\"type\"]').change(function(){
		 load_plugin();
	});

	$('#vali .tag a').click(function(){
		$(this).parent('span:first').remove();
	});
	$('.add').click(function(){
		var k = $('select[name=\"validate\"] option:selected').text(); 
		var i = $('select[name=\"validate\"]').val(); 
		var j = $('input[name=\"validate_value\"]').val();  
		$('#copy span').html(k+j);
		$('#copy input').val(i+j);
		if($('#copy').find('input').val())
			$('#vali').append('<span class=\"tag\">'+$('#copy').html()+'</span>');
		$('#vali .tag a').click(function(){
			$(this).parent('span:first').remove();
		});  
	});
	$('form').ajaxForm({ 
        target: '#update',
        url: '".$url."',     
		type: 'post', 
		beforeSend: function(arr) { 
		    $('#edit_field button[type=\"submit\"]').attr('disabled','disabled');
		},
        success: function(data) {  
        	if(data==1){
        		window.location = '".action('core/type/fileds',array('id'=>$pid))."';        		 
        		return false;
        	}
            $('#update').css('color','#b94a48').fadeIn('slow') 
            	.animate({opacity: 1.0}, 1000).fadeOut('slow');
        } 
    }); 
			 

		 

	");


?>
@endsection