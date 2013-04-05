<?php
Asset::add('browserplus','misc/plupload/js/browserplus-min.js'); 
Asset::add('plupload','misc/plupload/js/plupload.full.js'); 
$files = $one->$f['value']; 
$filter = '*';
if($f['validate']){
	foreach($f['validate'] as $v){
		if(strpos($v,'mimes')!==false){
			$filter = str_replace('mimes:','',$v);
		}
	}
}
 
?> 
<script type="text/javascript">
// Custom example logic
$(function() {
	var container = "container__{{$f['value'];}}";
	var filelist = "filelist__{{$f['value'];}}";
 	var pickfiles = "pickfiles__{{$f['value'];}}";
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : pickfiles,
		container : container,
		multipart_params:{field:"{{$f['value'];}}"},
		max_file_size : '10mb',
		url : "{{action('core/file/upload')}}",
		flash_swf_url : "{{URL::base();}}misc/plupload/js/plupload.flash.swf",
		silverlight_xap_url : '{{URL::base();}}misc/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : "File", extensions : "{{$filter}}"},
		 
		],
		 
	});

	uploader.bind('Init', function(up, params) {
		//$('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
	});

	$('#uploadfiles').click(function(e) {
		uploader.start();
		e.preventDefault();
	});

	uploader.init(); 
 
	uploader.bind('FilesAdded', function(up, files) { 
		$.each(files, function(i, file) {
			$('#'+filelist).append(
				'<div id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'</div>');
			uploader.start();  
		});  
		up.refresh(); // Reposition Flash/Silverlight
	});
	uploader.bind('UploadComplete', function(up, file) { 
	 	
	});  
	uploader.bind('UploadProgress', function(up, file) {
		$('#' + file.id + " b").html(file.percent + "%");
	}); 
	uploader.bind('Error', function(up, err) {
		$('#'+filelist).append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		); 
		up.refresh(); // Reposition Flash/Silverlight
	}); 
	uploader.bind('FileUploaded', function(up, file,data) {  
		data = eval(data);
		data = eval('('+data.response+')'); 
	 	$('#'+filelist).append(data.tag);
		$('#' + file.id + " ").html("");
		$('#node_form .file .icon-remove').click(function(){
			$(this).parent('div.file:first').remove();
		});
	});
});
 
</script>
 
<div id="container__{{$f['value'];}}"> 
	<i id="pickfiles__{{$f['value'];}}" class="hand icon-upload icon-2x"></i> 
	 
	<div id="filelist__{{$f['value'];}}">
		@if($files)
			{{Helper::cck_files($files,$f['value']);}}
		@endif
	</div>   
</div>
<div style="clear:both;"></div>

<?php 
	 
	CMS::script(
	'file_sort', 
	" 
	 
	$( '#filelist__".$f['value']." ' ).sortable(); 
 
	
	"
	
	);	
	?>