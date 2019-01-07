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
	<div class="panel-heading">
		Floats Uploaded
		<span class="label label-info pull-right">{{ count($results) }} Items</span>
	</div>
	<div class="padding-md clearfix">
		<table class="table table-striped" id="dataTable">
			<thead>
				<tr>
					<th>SL</th>
					<th>File Name</th>
					<th>Upload Time</th>
				</tr>

			</thead>

			<tbody>
				@foreach($results as $k => $v)
					<tr>
						<td>{{ $k+1 }}</td>
						<td><a href="{{ route('mail.fresh_float.hospital_view', $v->id ) }}" target="_blank"> {{ $v->name }}</a></td>
						<td>{{ date('d-m-Y h:i A', strtotime($v->upload_time)) }}</td>

					</tr>
				@endforeach
			</tbody>
		</table>
	</div><!-- /.padding-md -->
</div><!-- /panel -->


@endsection