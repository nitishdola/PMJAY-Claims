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
		<div class="panel-heading">Edit : <b>{{ $hospital->name }}</b></div>
		<div class="panel-body">
			{!! Form::model($hospital, array('route' => ['hospital.update', $hospital->id], 'id' => 'hospital.update')) !!}

			<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Hospital Name</label>
			    {!! Form::text('name', null, ['class' => 'form-control required col-md-5', 'id' => 'name', 'placeholder' => 'Hospital Name', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Hospital Address</label>
			    {!! Form::text('address', null, ['class' => 'form-control required col-md-5', 'id' => 'address', 'placeholder' => 'Hospital Name', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('address', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>



			<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Email</label>
			    {!! Form::text('email', null, ['class' => 'form-control required col-md-5', 'id' => 'email', 'placeholder' => 'Email ID', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('email', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Phone Number</label>
			    {!! Form::text('phone_number', null, ['class' => 'form-control required col-md-5', 'id' => 'phone_number', 'placeholder' => 'Phone Number', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('phone_number', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>

			<button type="submit" class="btn btn-sm btn-primary">
			<i class="fa fa-dot-circle-o"></i> Update Information</button>

			<a class="btn btn-sm btn-danger" href="{{ route('hospital.index') }}">
			<i class="fa fa-times"></i> Cancel</a>

		
			{!! Form::close() !!}
		</div>
	</div><!-- /panel -->
</div><!-- /.col -->

@endsection