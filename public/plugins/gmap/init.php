<?php namespace Plugins\Gmap;

class Init{ 
    
 	static function view($parmas){ 
 	 	$id = $parmas['id'];
 	 	$aid = $parmas['aid'];
 		$address = $parmas['address'];	
 		name_assets('top', 'https://maps.googleapis.com/maps/api/js?sensor=false');
 		if($aid) $adword = "var adUnitDiv = document.createElement('div');
		var adUnitOptions = {
		  format: google.maps.adsense.AdFormat.VERTICAL_BANNER,
		  position: google.maps.ControlPosition.RIGHT_CENTER,
		  publisherId: '".$aid."',
		  map: map,
		  visible: true
		};
		var adUnit = new google.maps.adsense.AdUnit(adUnitDiv, adUnitOptions);";
 		\CMS::javascript('gmap_'.$id,"
			var geocoder, map, adUnit;
			function codeAddress(address) {
			    geocoder = new google.maps.Geocoder();
			    geocoder.geocode( { 'address': address}, function(results, status) {
			      if (status == google.maps.GeocoderStatus.OK) {
			        var myOptions = {
			        zoom: 14,
			        center: results[0].geometry.location,
			        mapTypeId: google.maps.MapTypeId.ROADMAP
			        }
			        
			        map = new google.maps.Map(document.getElementById('".$id."'), myOptions);
					
			        var marker = new google.maps.Marker({
			            map: map,
			            position: results[0].geometry.location
			        });
			        
			        ".$adword."
			        
	
			       
			      }
			    });
			    
				
  
			 } 
      		codeAddress('".$address."');
 	 "); 
	  
 	}
	 
	
}