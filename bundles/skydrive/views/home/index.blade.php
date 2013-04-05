@layout('core::layout') 
 
@section('content') 
	@foreach($imgs as $img)
 		<?php $im = $img[1];$im0 = $img[0];$full = $img[3];?>
		<a href='{{$full->source}}' rel="{{$im0->source}}"target="_blank">{{HTML::image($im->source)}}</a>
	@endforeach
				
@endsection