@extends('default')

@section('main_content')
@if($errors)
	@foreach($errors as $error)
		<div class="alert alert-danger">
			<h4>{{ $error }}</h4>
		</div>
	@endforeach
@endif


<div class="panel panel-default table-responsive">

	<div class="row">
		{!! Form::open(array('route' => 'hospital.index', 'class' => 'form-horizontal', 'method' => 'GET')) !!}
			<br><br>
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Hospital Type</label>  
			  <div class="col-md-4">

			  	<?php 
			  	$hospital_types['Public'] = 'Public'; 
			  	$hospital_types['Trust'] = 'Trust'; 
			  	$hospital_types['Private'] = 'Private'; 
			  	?>
			 {!! Form::select('hospital_type', $hospital_types, null, ['class' => 'form-control required col-md-5', 'id' => 'name', 'placeholder' => 'Hospital Type', 'autocomplete' => 'off']) !!} 
			  </div>
			</div>


			<br><br>
			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput">Hospital Name</label>  
			  <div class="col-md-4">
			 {!! Form::select('hospital_id', $hospitals, null, ['class' => 'form-control required col-md-5 select2', 'id' => 'name', 'placeholder' => 'Select Hospital', 'autocomplete' => 'off']) !!} 
			  </div>
			</div>

			<div class="form-group">
			  <label class="col-md-4 control-label" for="textinput"></label>  
			  <div class="col-md-4">
			  	<button type="submit" class="btn btn-sm btn-primary">
					<i class="fa fa-dot-circle-o"></i> Search</button>
			  </div>
			</div>

			
		
		{!! Form::close() !!}
	</div>
	<div class="panel-heading">
		
		<a class="btn btn-danger btn-sm" href="{{ route('hospital.create') }}">Add New Hospital</a>
	</div>
	<div class="padding-md clearfix">
		@if(count($results))
		<table class="table table-bordered" id="dataTable">
			<thead>
				<tr>
					<th>SL</th>
					<th>Hospital Name</th>
					<th>Address</th>
					<th>Email</th>
					<th>Phone Number</th>
					<th>Total Paid</th>
					<th>View Details</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>

			</thead>

			<tbody>
				<?php $total = 0; ?>
				@foreach($results as $k => $v)
					<tr>
						<td>{{ $k+1 }}</td>
						<td>{{ $v->name }}</td>
						<td>{{ $v->address }}</td>
						<td>{{ $v->email }}</td>
						<td>{{ $v->phone_number }}</td>
						<?php
							$paid = DB::table('floats')->where('status',1)->where('hospital_id', $v->id)->sum('net_amount');
						?>
						<td>{{ number_format((float)$paid, 2, '.', '') }}</td>
						<?php $total += $paid; ?>

						<td><a target="_blank" class="btn btn-xs btn-info" href="{{ route('hospital.details', $v->id) }}"><i class="fa fa-location-arrow" aria-hidden="true"></i> View Details</a></td>

						<td><a class="btn btn-xs btn-primary" href="{{ route('hospital.edit', $v->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></td>

						<td><a class="btn btn-xs btn-danger" href="{{ route('hospital.disable', $v->id) }}"><i class="fa fa-pencil-square-o" onclick="return confirm('are you sure ?')" aria-hidden="true"></i> Delete</a></td>
					</tr>
				@endforeach
			</tbody>

			<tfoot>
				<tr>
					<td colspan="5"> Total</td>
					<td>{{ number_format((float)$total, 2, '.', '') }}</td>
				</tr>
			</tfoot>
		</table>
		@else
		<div class="alert alert-warning">
			<h3>NO RESULTS FOUND</h3>
		</div>
		@endif
	</div><!-- /.padding-md -->
</div><!-- /panel -->


@endsection