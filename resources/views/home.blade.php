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
		@if(count($results))
		<table class="table table-striped" id="dataTable">
			<thead>
				<tr>
					<th>SL</th>
					<th>File Name</th>
					<th>Float Number</th>
					<th>Mail Status</th>
					<th>Upload Time</th>
				</tr>

			</thead>

			<tbody>
				@foreach($results as $k => $v)
					<tr @if($v->mail_time) class="alert alert-success" @endif>
						<td>{{ $k+1 }}</td>
						<td><a href="{{ route('mail.fresh_float.hospital_view', $v->id ) }}" target="_blank"> {{ $v->name }}</a></td>
						<td><a href="{{ route('mail.fresh_float.hospital_view', $v->id ) }}" target="_blank"> {{ $v->float_number }}</a></td>

						<td>
							@if($v->mail_time) 
								Mail Sent on {{ date('d-m-Y h:i', strtotime($v->mail_time))}}
							@else
								Mail Not Sent
							@endif
						</td>

						<td>{{ date('d-m-Y h:i A', strtotime($v->upload_time)) }}</td>

					</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<div class="alert alert-warning">
			<h3>NO RESULTS FOUND</h3>
		</div>
		@endif
	</div><!-- /.padding-md -->
</div><!-- /panel -->


@endsection