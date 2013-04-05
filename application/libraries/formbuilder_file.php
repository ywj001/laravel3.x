<?php
Asset::add('browserplus','misc/plupload/js/browserplus-min.js'); 
Asset::add('plupload','misc/plupload/js/plupload.full.js'); 
$files = $one->$f['value']; 
 
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
	function iconremove(){
		$('.file .icon-remove').click(function(){
			$(this).parent('div.file:first').remove();
		});
	}
	iconremove();
	var container = "container__<?php echo $f['value'];?>";
	var filelist = "filelist__<?php echo $f['value'];?>";
 	var pickfiles = "pickfiles__<?php echo $f['value'];?>";
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : pickfiles,
		container : container,
		multipart_params:{field:"<?php echo $f['value'];?>"}, 
		url : "<?php echo action('core/file/upload')?>",
		flash_swf_url : "<?php echo URL::base();?>misc/plupload/js/plupload.flash.swf",
		silverlight_xap_url : '<?php echo URL::base();?>misc/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : "File", extensions : "<?php echo $filter?>"},
		 
		],
		max_file_size : "<?php echo $max_file_size; ?>",
		filters : [
	        {title : "File", extensions :"<?php echo $ext; ?>"}
	       
	    ]

		 
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
 
<div id="container__<?php echo $f['value'];?>"> 
	<i id="pickfiles__<?php echo $f['value'];?>" class="hand icon-upload icon-2x"></i>  
	<div id="filelist__<?php echo $f['value'];?>">
		<?php if($files){?>
			<?php echo Helper::cck_files($files,$f['value']);?>
		<?php } ?>
	</div>   
</div>
<div style="clear:both;"></div>

<?php 
	assets('misc/jui/jquery-ui.js'); 
   	assets("misc/jui/css/flick/jquery-ui.min.css");
   	CMS::style('formbuilder_file',".file .icon-remove {
position: absolute;
top: 0;
right: 0;
z-index: 50;
}
.file {
margin-bottom: 10px;
float: left;
margin-right: 10px;
position: relative;
}");
	CMS::script(
	'file_sort', 
	"  
	$( '#filelist__".$f['value']." ' ).sortable(); 
 
	
	"
	
	);	
	?>