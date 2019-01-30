@extends('default')

@section('main_content')
{{ dump($errors) }}
@if($errors)
	@foreach($errors as $error)
		<div class="alert alert-danger">
			<h4>{{ $error }}</h4>
		</div>
	@endforeach
@endif


<div class="col-md-6">
	<div class="panel panel-default">
		<div class="panel-heading">Upload</div>
		<div class="panel-body">
			{!! Form::open(array('route' => 'save_data', 'id' => 'save_data', 'files' => true)) !!}

			<div class="form-group {{ $errors->has('data_file') ? 'has-error' : ''}}">
			  {!! Form::label('float_file*', '', array('class' => '')) !!}
			    <input type="file" name="data_file" required="required"> 
			  {!! $errors->first('data_file', '<span class="help-inline">:message</span>') !!}
			</div>

		<button type="submit" class="btn btn-sm btn-primary">
			<i class="fa fa-dot-circle-o"></i> Submit</button>
		
			{!! Form::close() !!}
		</div>
	</div><!-- /panel -->
</div><!-- /.col -->

@endsection