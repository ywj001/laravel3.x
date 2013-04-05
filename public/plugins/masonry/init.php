<?php namespace Plugins\Masonry;
class Init{ 
	static function view($params=null){
		$old = $params;
		$tag = $params['tag']; 
		$bottom = $parmas['bottom']?:true; 
		$itemSelector = $params['itemSelector'] = $params['itemSelector']?:'.item';
		unset($params['tag'],$parmas['bottom']);
		 
		$params = \JS::encode($params);
		\Asset::add('masonry',\URL::base().'/plugins/masonry/js/jquery.masonry.min.js');
		\Asset::add('imagesloaded',\URL::base().'/plugins/masonry/js/jquery.imagesloaded.min.js'); 
		if(!$tag) return;
		if(array_key_exists('scroll',$old) && $old['scroll']===true){
			\Asset::add('infinitescroll',\URL::base().'/plugins/masonry/js/jquery.infinitescroll.js');
			\CMS::style('infinitescroll',"#infscr-loading{clear:both; position: absolute;padding-left:10px;bottom: -25px;width: 200px;}#infscr-loading img{float: left;margin-right: 5px;}");
			\CMS::script('masonry_'.$tag," 
				var \$container = $('".$tag."');
		 		\$container.imagesLoaded(function(){
			     \$container.masonry($params);
			    });   
				var \$container = $('".$tag."');
					\$container.infinitescroll({ 
					loading:{ 
				    	img:'".\URL::base()."/img/ajax-loader.gif',
					    msgText:'".__('admin.loading content……')."',  
					    finishedMsg:'".__('admin.content loading finished')."'
				    },
				    dataType: 'html',
				    navSelector  : 'div.pagination',   
				    nextSelector : 'div.pagination a',    
				    itemSelector : '".$itemSelector."', 
				 },  
				  function( newElements ) {
				    var \$newElems = $( newElements ).css({ opacity: 0 });
			        \$newElems.imagesLoaded(function(){
			          \$newElems.animate({ opacity: 1 });
			          \$container.masonry( 'appended', \$newElems, true ); 
			        });

				  }
				); 
			"); 
		}else{
			\CMS::script('masonry_'.$tag,"
				var \$container = $('".$tag."');
		 		\$container.imagesLoaded(function(){
			     \$container.masonry($params);
			    });  
			"); 
		
		}
		 
	}
 
}