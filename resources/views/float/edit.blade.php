@extends('default')

@section('main_content')
@if($errors)
	@foreach($errors as $error)
		<div class="alert alert-danger">
			<h4>{{ $error }}</h4>
		</div>
	@endforeach
@endif


<div class="col-md-8">
	<div class="panel panel-default" style="min-height: 1200">
		<div class="panel-heading">Edit : <b>{{ $float->tpa_claim_reference_number }}</b></div>
		<div class="panel-body" style="min-height: 1200">
			{!! Form::model($float, array('route' => ['claim_float.update', $float->id], 'id' => 'claim_float.update')) !!}

			<div class="form-group {{ $errors->has('float_serial_number') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Float Sl No</label>
			    {!! Form::text('float_serial_number', null, ['class' => 'form-control required col-md-5', 'id' => 'float_serial_number', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('float_serial_number', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>

			<div class="form-group {{ $errors->has('patient_name') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Patient Name</label>
			    {!! Form::text('patient_name', null, ['class' => 'form-control required col-md-5', 'id' => 'patient_name', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('patient_name', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>

			<div class="form-group {{ $errors->has('hospital_id') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Patient Name</label>
			    {!! Form::select('hospital_id', $hospitals, null, ['class' => 'form-control required col-md-5', 'id' => 'hospital_id', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('hospital_id', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('tpa_claim_reference_number') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">TPA CLaim Referance Number</label>
			    {!! Form::text('tpa_claim_reference_number', null, ['class' => 'form-control required col-md-5', 'id' => '	tpa_claim_reference_number', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('tpa_claim_reference_number', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>

			<div class="form-group {{ $errors->has('date_of_admission') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Date of Admission</label>
			    {!! Form::text('date_of_admission', null, ['class' => 'form-control required col-md-5 datepicker', 'id' => 'date_of_admission', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('date_of_admission', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>

			<div class="form-group {{ $errors->has('date_of_discharge') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Date of Discharge</label>
			    {!! Form::text('date_of_discharge', null, ['class' => 'form-control required col-md-5 datepicker', 'id' => 'date_of_discharge', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('date_of_discharge', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>

			<div class="form-group {{ $errors->has('gross_bill') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Gross Bill</label>
			    {!! Form::number('gross_bill', null, ['class' => 'form-control required col-md-5', 'id' => 'gross_bill', 'step' => '0.01', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('gross_bill', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('deduction') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Deduction</label>
			    {!! Form::number('deduction', null, ['class' => 'form-control required col-md-5', 'id' => 'deduction', 'step' => '0.01', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('deduction', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('tds') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">TDS</label>
			    {!! Form::number('tds', null, ['class' => 'form-control required col-md-5', 'id' => 'tds', 'step' => '0.01', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('tds', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>

			<div class="form-group {{ $errors->has('net_amount') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Net Amount</label>
			    {!! Form::number('net_amount', null, ['class' => 'form-control required col-md-5', 'id' => 'net_amount', 'step' => '0.01', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('net_amount', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('date_of_payment') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Date of Payment</label>
			    {!! Form::text('date_of_payment', null, ['class' => 'form-control required col-md-5 datepicker', 'id' => 'date_of_payment', 'placeholder' => '', 'required' => true, 'autocomplete' => 'off']) !!}

			     {!! $errors->first('date_of_payment', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('utr_number') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">UTR Number</label>
			    {!! Form::text('utr_number', null, ['class' => 'form-control required col-md-5', 'id' => 'utr_number', 'placeholder' => 'UTR Number', 'autocomplete' => 'off']) !!}

			     {!! $errors->first('utr_number', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<div class="form-group {{ $errors->has('remarks') ? 'has-error' : ''}}">
			    <label for="text-input" class=" form-control-label">Remarks</label>
			    {!! Form::text('remarks', null, ['class' => 'form-control required col-md-5', 'id' => 'remarks', 'placeholder' => 'Remarks', 'autocomplete' => 'off']) !!}

			     {!! $errors->first('remarks', '<span class="help-inline">:message</span>') !!}
			</div>
			<br><br>


			<button type="submit" class="btn btn-sm btn-primary">
			<i class="fa fa-dot-circle-o"></i> Update Information</button>

			<a class="btn btn-sm btn-danger" href="{{ route('home') }}">
			<i class="fa fa-times"></i> Cancel</a>

		
			{!! Form::close() !!}
		</div>
	</div><!-- /panel -->
</div><!-- /.col -->

@endsection