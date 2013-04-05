@layout('core::layout') 
@section('content') 
	@foreach ($posts->results as $post) 
		 <table class="table table-bordered"> 
			<tbody>
				<tr> 
					<td><strong style="font-size:25px;">{{$post->label}}</strong></td>
					<td class="tr"> 
					</td>
				</tr>
			</tbody>
		</table> 
	@endforeach
   {{$posts->links();}}
   
   {{Form::open();}} 
		<p>
			{{Form::label('label',__('admin.label'));}} 
			{{Form::text('label');}} 
		</p>
		<p>
			{{Form::label('value',__('admin.value'));}} 
			{{Form::text('value');}} 
		</p>
	 	<p>
			{{Form::label('condition',__('admin.condition'));}} 
			{{Form::text('condition');}} 
		</p>
		<button type="submit" class="btn">{{__('admin.save')}}</button>
	{{Form::close();}}
	
@endsection