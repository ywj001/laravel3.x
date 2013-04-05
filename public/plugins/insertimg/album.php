<div id="hook_node_album_<?php echo $img;?>">
	<div class='ajax-pager'><?php echo $data->links();?></div>
	<div style='clear:both;'></div>
	<div class='content'>
	<?php foreach($data->results as $post){?>
		<?php if(imagecache($post->path,1)){?>
			<?php echo HTML::image(imagecache($post->path,1),null,array('rel'=>'/'.$post->path,'tt'=>'app_'.$img.$post->id));?>
			<div class="file" style='display:none;' id="<?php echo 'app_'.$img.$post->id;?>">
				<span class="icon-remove hand"></span>
				<input type="hidden" name="<?php echo $img.'[]';?>" value="<?php echo $post->id;?>">
				<a href="<?php echo imagecache($post->path,3);?>" rel="lightbox[]">
				<img src="<?php echo imagecache($post->path,1);?>" alt="">
				</a>
			</div>
		<?php }?>
	<?php }?>
	</div>
</div>
<style> 
img{float:left;margin-right:10px;margin-bottom:10px;}
.ajax-pager .pagination{float:none;}
</style>
<script src="/misc/jquery/jquery.min.js"></script> 
<script>
	$(function(){
 
			$("#hook_node_album_<?php echo $img;?> img").click(function(){
				$("#filelist__<?php echo $img;?>").append("<div class='file'>"+$('#'+$(this).attr('tt')).html()+"</div>");
				$('#node_form .file .icon-remove').click(function(){
					$(this).parent('div.file:first').remove();
				});
			});
	 
		$("#hook_node_album_<?php echo $img;?> .ajax-pager li a").click(function(){
			$.post($(this).attr('href'),function(data){ 
			 	if($(data).find('.content').length>0) 
					$("#hook_node_album_<?php echo $img;?>").html(data);
				$("#hook_node_album_<?php echo $img;?> img").click(function(){
				$("#filelist__<?php echo $img;?>").append("<div class='file'>"+$('#'+$(this).attr('tt')).html()+"</div>");
					$('#node_form .file .icon-remove').click(function(){
						$(this).parent('div.file:first').remove();
					});
				});
			});	
			return false;
		});	
	}); 
</script>