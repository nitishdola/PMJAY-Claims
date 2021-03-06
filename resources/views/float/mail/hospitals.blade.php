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
		Float : <strong>{{ $float_file->name }}</strong>
		<?php $float_file_id = $float_file->id; ?>
		<span class="label label-info pull-right">{{ count($hospitals) }} Items</span>
	</div>
	<div class="padding-md clearfix">
		<table class="table table-striped" id="dataTable">
			<thead>
				<tr>
					<th>SL</th>
					<th>Hospital Name</th>
					<th>Total Cases</th>
					<th>Gross Amount</th>
					<th>Deduction</th>
					<th>TDS</th>
					<th>Net Amount</th>
					
					<th>Send Mail</th>
				</tr>

			</thead>
			<?php 
				$all_gross = $all_deduction = $all_tds = $all_net = 0;
			?>
			<tbody>
				@foreach($hospitals as $k => $v)
				<?php 
					$hospital_id = $v['id']; 
					$hospital = DB::table('hospitals')->where('id', $hospital_id)->first();
				?>
					<tr>
						<td>{{ $k+1 }}</td>
						<td>{{ $hospital->name }} <br> {{ $hospital->email }}</td>

						<?php 
							$hospital_email = $hospital->email;

							$gross = $deduction = $tds = $net = 0;
							$hospital_data = DB::table('floats')
											->where('status',1)
											->where('float_file_id', $float_file_id)
											->where('hospital_id', $v['id'])
											->get();

							foreach($hospital_data as $k1 => $v1) {
								$gross 		+= (float) $v1->gross_bill;
								$all_gross  += (float) $v1->gross_bill;

								$deduction 	+= (float) $v1->deduction;
								$all_deduction 	+= (float) $v1->deduction;

								$tds 		+= (float) $v1->tds;
								$all_tds 		+= (float) $v1->tds;

								$net 		+= (float) $v1->net_amount;
								$all_net 		+= (float) $v1->net_amount;
							}


							//claim float
						?>

						<td>{{ count($hospital_data) }}</td>
						
						<td>{{ $gross }}</td>
						<td>{{ $deduction }}</td>
						<td>{{ $tds }}</td>
						<td>{{ $net }}</td>
						

						<td>
							
							<button id="send_mail_btn_{{$hospital_id}}" class="btn btn-xs btn-danger send_mail" onclick="sendMail({{ $hospital_id }}, '{{ $hospital_email }}', {{ $float_file_id }})">Send Mail <br>to Hospital</button>

							<button style="display: none;" id="send_mail_loading_btn_{{$hospital_id}}" class="btn btn-primary btn-sm"><i class="fa fa-spinner fa-spin"></i> Sending Mail</button>


							<button style="display: none;" id="send_mail_sent_btn_{{$hospital_id}}" class="btn btn-success btn-sm"><i class="fa fa-check-square" aria-hidden="true"></i> Mail Sent</button>
							

						</td>
					</tr>

				@endforeach


			</tbody>

			<tfoot>
				<tr>
					<td colspan="3"> TOTAL</td>
					<td> {{ $all_gross }}</td>
					<td> {{ $all_deduction }}</td>
					<td> {{ $all_tds }}</td>
					<td> {{ $all_net }}</td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	</div><!-- /.padding-md -->
</div><!-- /panel -->

@endsection

@section('pageJs')
<script>
function sendMail(hospital_id, email, float_file_id) {
	$('#send_mail_btn_'+hospital_id).hide();
	$('#send_mail_loading_btn_'+hospital_id).show();

	data = url = '';

	data = '&hospital_id='+hospital_id+'&email='+email+'&float_file_id='+float_file_id;
	url  = "{{ route('mail.send_mail') }}";

	console.log(url+data);
	$.ajax({
		data : data,
		url  : url,
		type : 'GET',

		error : function(resp) {
			console.log(resp);
		},

		success : function(resp) {
			if(resp == 1) {
				$('#send_mail_loading_btn_'+hospital_id).hide();
				$('#send_mail_sent_btn_'+hospital_id).show();
			}else{
				alert(resp);
				$('#send_mail_btn_'+hospital_id).show();
			}
			
		}
	});

}
</script>
@stop