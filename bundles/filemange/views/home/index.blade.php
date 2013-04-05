@layout('core::layout') 
@section('content')  

<?php
Asset::add('browserplus','misc/plupload/js/browserplus-min.js'); 
Asset::add('plupload','misc/plupload/js/plupload.full.js'); 
?>
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
			{title : "Image files", extensions : "jpg,gif,png,jpeg,bmp"}, 
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
			$('#filelist').append(
				'<div id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'</div>');
			uploader.start();  
		});  
		up.refresh(); // Reposition Flash/Silverlight
	});
	uploader.bind('UploadComplete', function(up, file) { 
		window.location.href=window.location.href;
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
		$('#' + file.id + " b").html("100%");
	});
});
 
</script>
 
<div id="container"> 
	<div id='filelist'></div> 
	<i id="pickfiles" class="icon-cloud-upload icon-2x"></i> 
</div>
	
<div id="masonry">
	@if($posts)
		@foreach($posts->results as $post)
		<div class='item'> 
			<a href="{{imagecache($post->path,4)}}" tag="{{$post->path}}" rel='lightbox[]' class='jqzoom'>
			{{HTML::image(imagecache($post->path,1))}}
			</a>
		</div> 
		@endforeach
	@endif
</div>	
<div style="margin-top:50px;"></div>
@if($posts->last)
{{PagerHelper::next($posts->last);}}
@endif
<?php 
CMS::style('httpimage',"
#masonry .item {
  width: 130px;
  margin: 5px;
  float: left;
}
#masonry .item span{
position: absolute;
top: 0;
left: 0;
cursor:pointer;
z-index:9999;
}
#masonry .item img{ 
  float: left;
}
");
?>
@endsection