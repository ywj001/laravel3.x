@layout('core::layout') 
@section('content')  
<?php 
CMS::script('fouce_name',"
	$('#name').focus(); 
	");
?>
		 <div class=" ">
	        <legend>{{__('admin.create taxonomy')}} </legend>
		 
	        {{Form::open($url);}} {{Form::token();}}  
	        	
	            <p>
	            	<label>{{__('admin.name');}}</label>
		            <input class="span3"   type="text"   placeholder="{{__('admin.name')}}" id='name' name="name" value="
@if(!Input::get('name'))
{{$first->name}}
@else
{{Input::get('name')}}
@endif
">  
					@if($validation)
		            	{{$validation->first('name',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	            <p>
	            	<label>{{__('admin.parent');}}</label>
	            	<select name='pid' id='pid'>
	            		{{$tree}}
	            	</select>
		             
					@if($validation)
		            	{{$validation->first('pid',"<p class='alert alert-error'>:message</p>")}}
		            @endif  
	            </p> 
	                   	
	            <br>
	            <button class="btn-info btn" type="submit">
	            	@if($first)
	            		{{__('admin.update taxonomy')}}
	            	@else
	            		{{__('admin.create taxonomy')}}
	            	@endif
	            	</button>    
	            <a style="margin-left:10px;" href="{{action('core/taxonomy/index',array('taxonomy_id'=>$_GET['back_taxonomy_id']));}}" class="btn">
	            	  <strong>{{__('admin.back')}}</strong>
	            </a>  
		     {{Form::close();}}
	      </div>
		 <?php 
		 CMS::script('select_taxonomy_id',"
		  	var tax = ".$taxonomy_id.";
		  	$('#pid option').each(function(){
		  		var v = $(this).val();
		  		if(v==tax){
		  			$(this).attr('selected','selected');
		  		}
		  	});
		  ");	  
		 
		 ?>
 					
@endsection