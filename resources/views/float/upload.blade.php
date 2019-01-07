@extends('default')

@section('main_content')
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
			{!! Form::open(array('route' => 'float_data.save', 'id' => 'float_data.save', 'files' => true)) !!}

			<div class="form-group {{ $errors->has('data_file') ? 'has-error' : ''}}">
			  {!! Form::label('float_file*', '', array('class' => '')) !!}
			    <input type="file" name="data_file" required="required"> 
			  {!! $errors->first('data_file', '<span class="help-inline">:message</span>') !!}
			</div>

			<div class="form-group {{ $errors->has('float_number') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Float Number*</label>
			    {!! Form::text('float_number', null, ['class' => 'form-control required col-md-5', 'id' => 'float_number', 'placeholder' => 'Float Number', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('float_number', '<span class="help-inline">:message</span>') !!}
			</div>

			<br><br>
			<div class="form-group {{ $errors->has('payment_advice_file') ? 'has-error' : ''}}">
			  {!! Form::label('payment_advice_file', '', array('class' => '')) !!}
			    <input type="file" name="payment_advice_file" > 
			  {!! $errors->first('payment_advice_file', '<span class="help-inline">:message</span>') !!}
			</div>

		<button type="submit" class="btn btn-sm btn-primary">
			<i class="fa fa-dot-circle-o"></i> Submit</button>
		
			{!! Form::close() !!}
		</div>
	</div><!-- /panel -->
</div><!-- /.col -->

@endsection