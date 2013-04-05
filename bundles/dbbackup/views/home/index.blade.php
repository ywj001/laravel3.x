@layout('core::layout') 
 
@section('content') 
<p><a href="{{action('dbbackup/home/backup')}}" class="btn">
	<i class="icon-signout"></i> <strong>{{__('admin.backup')}}</strong>
</a></p> 
<div class="row-fluid">  
	<div class="span12 m-widget"> 
		<div class="m-widget-body">
			<table class="table table-bordered  table-hover "> 
				<tbody>
					@foreach($path  as $k=>$v)	
					<tr> 
						<td><strong style='font-size:25px;'>{{$k}}</strong></td>
						<td class="tr">
						
						</td>
					</tr>
					<?php $files = $v['files'];
						krsort($files);
					?>
					@foreach($files  as $vo)	
						@if(!in_array($vo,array('.','..')))
							<?php $file = $dbdir.'/'.$k.'/'.$vo;?>
							<tr> 
								<td>{{$vo}}[{{FileHelper::size($file)}}]</td>
								<td class="tr">
									<a href="{{action('dbbackup/home/down').'?name='.$k.'/'.$vo.'&ext='.$k;}}" class="btn">
										<i class="icon-cloud-download"></i> <strong>{{__('admin.download')}}</strong></a>
											
									<a href="{{action('dbbackup/home/restore').'?name='.$k.'/'.$vo;}}" class="btn">
										<i class="icon-reply"></i> <strong>{{__('admin.restore')}}</strong>
									</a>
 								</td>
							</tr>
						@endif
					@endforeach		
				    @endforeach
				</tbody>
			</table>
			
			
		</div>
	  </div>
</div>	
 

				
@endsection