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
			{!! Form::open(array('route' => 'hospital.save', 'id' => 'hospital.save')) !!}

			<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
			  {!! Form::label('name*', '', array('class' => '')) !!}
			    <input type="text" name="name" class="form-control" required="required"> 
			  {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
			</div>

			<div class="form-group {{ $errors->has('bed_strength') ? 'has-error' : ''}}">
			  {!! Form::label('bed_strength*', '', array('class' => '')) !!}
			    <input type="text" name="bed_strength" class="form-control" required="required"> 
			  {!! $errors->first('bed_strength', '<span class="help-inline">:message</span>') !!}
			</div>

			<?php 
				$hospital_types['Public'] 				= 'Public';
				$hospital_types['Trust'] 				= 'Trust';
				$hospital_types['Private (For Profit)'] = 'Private (For Profit)';
			?>
			<div class="form-group {{ $errors->has('bed_strength') ? 'has-error' : ''}}">
			  {!! Form::label('bed_strength*', '', array('class' => '')) !!}
			    {!! Form::select('hospital_type', $hospital_types, null, ['class' => 'form-control required', 'id' => 'hospital_type', 'placeholder' => 'Hospital Type', 'autocomplete' => 'off', 'required' => 'true']) !!}
			  {!! $errors->first('hospital_type', '<span class="help-inline">:message</span>') !!}
			</div>

			<div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
			  {!! Form::label('address*', '', array('class' => '')) !!}
			    {!! Form::text('address', null, ['class' => 'form-control required', 'id' => 'address', 'placeholder' => 'Address', 'autocomplete' => 'off', 'required' => 'true']) !!}
			  {!! $errors->first('address', '<span class="help-inline">:message</span>') !!}
			</div>

			<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
			  {!! Form::label('email*', '', array('class' => '')) !!}
			    {!! Form::text('email', null, ['class' => 'form-control required', 'id' => 'email', 'placeholder' => 'Email', 'autocomplete' => 'off', 'required' => 'true']) !!}
			  {!! $errors->first('email', '<span class="help-inline">:message</span>') !!}
			</div>


			<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
			  {!! Form::label('phone_number*', '', array('class' => '')) !!}
			    {!! Form::number('phone_number', null, ['class' => 'form-control required', 'id' => 'phone_number', 'placeholder' => 'Phone Number', 'autocomplete' => 'off']) !!}
			  {!! $errors->first('phone_number', '<span class="help-inline">:message</span>') !!}
			</div>


			<div class="form-group {{ $errors->has('district_id') ? 'has-error' : ''}}">
			  {!! Form::label('district*', '', array('class' => '')) !!}
			    {!! Form::select('district_id',$districts, null, ['class' => 'form-control required', 'id' => 'district_id', 'placeholder' => 'Select Hospital District', 'autocomplete' => 'off']) !!}
			  {!! $errors->first('district_id', '<span class="help-inline">:message</span>') !!}
			</div>

			<?php 
				$nabh_options['No'] = 'No';
				$nabh_options['Yes'] = 'Yes';
			?>
			<div class="form-group {{ $errors->has('is_nabh') ? 'has-error' : ''}}">
			  {!! Form::label('is_nabh*', '', array('class' => '')) !!}
			    {!! Form::select('is_nabh',$nabh_options, null, ['class' => 'form-control required', 'id' => 'is_nabh', 'placeholder' => 'Select Hospital District', 'autocomplete' => 'off']) !!}
			  {!! $errors->first('is_nabh', '<span class="help-inline">:message</span>') !!}
			</div>



		<button type="submit" class="btn btn-sm btn-primary">
			<i class="fa fa-dot-circle-o"></i> Submit</button>
		
			{!! Form::close() !!}
		</div>
	</div><!-- /panel -->
</div><!-- /.col -->

@endsection