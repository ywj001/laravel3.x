@layout('core::layout') 
@section('content') 
{{HTML::script('misc/jquery/jquery-1.8.0.min.js');}} 
{{HTML::script('misc/plupload/js/browserplus-min.js');}}
{{HTML::script('js/comm.js');}}
{{HTML::script('misc/plupload/js/plupload.full.js');}}
<script type="text/javascript">
// Custom example logic
$(function() {
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : 'pickfiles',
		container : 'container',
		max_file_size : '10mb',
		url : "{{action('filemange/home/upload')}}",
		flash_swf_url : "{{URL::base();}}misc/plupload/js/plupload.flash.swf",
		silverlight_xap_url : '{{URL::base();}}misc/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		],
		resize : {width : 320, height : 240, quality : 90}
	});

	uploader.bind('Init', function(up, params) {
		//$('#filelist').html("<div>Current runtime: " + params.runtime + "</div>");
	});

	$('#uploadfiles').click(function(e) {
		uploader.start();
		e.preventDefault();
	});

	uploader.init(); 
	var url="";
	uploader.bind('FilesAdded', function(up, files) { 
		$.each(files, function(i, file) {
			$('#filelist').append(
				'<div id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'</div>');
			uploader.start(); 
		    url = "pin-action.php?img="+file.id+"&ext="+file.name;  
		    //alert(url);
		});  
		up.refresh(); // Reposition Flash/Silverlight
	});
	uploader.bind('UploadComplete', function(up, file) { 
		//window.location.href=url;
	});  
	uploader.bind('UploadProgress', function(up, file) {
		$('#' + file.id + " b").html(file.percent + "%");
	}); 
	uploader.bind('Error', function(up, err) {
		$('#filelist').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file,data) {  
		data = eval(data);
		data = eval('('+data.response+')'); 
	 	$('#files').append("<img src='/"+data.path+"' /><input type='hidden' value='"+data.id+"' >");
		$('#' + file.id + " b").html("100%");
	});
});
 
</script>
 
<div id="container"> 
	<div id='filelist'></div>
	<div id='files'></div>
	<i id="pickfiles" class="icon-cloud-upload icon-4x"></i> 
</div>
@endsection