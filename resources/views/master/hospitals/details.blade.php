@extends('default')

@section('main_content')
@if($errors)
	@foreach($errors as $error)
		<div class="alert alert-danger">
			<h4>{{ $error }}</h4>
		</div>
	@endforeach
@endif

<div class="padding-md">
	<div class="row">
		<div class="panel panel-default table-responsive">
			<div class="panel-heading">
				Hospitals Payment Details : <strong>{{ $hospital->name }}, {{ $hospital->address }}</strong>
				<span class="label label-info pull-right">{{ count($hospital_details) }} Items</span>
			</div>
			<div class="padding-md clearfix">
				@if(count($hospital_details))
				<table class="table table-bordered table-condensed" id="dataTablea">
					<thead>
						<tr>
							<th>SL</th>
							<th>Float No</th>
							<th>Patient Name</th>
							<th>Beneficiary District</th>
							<!-- <th>Hospital</th> -->
							<th>TPA Claim Referance Number</th>
							<th>Date of Admission</th>
							<th>Date of Discharge</th>
							<th>Gross Amount</th>
							<th>Deduction</th>
							<th>TDS</th>
							<th>Net Amount</th>
							<th>Date of Payment</th>
							<th>UTR Number</th>
						</tr>

					</thead>

					<tbody>
						<?php $net_amount = $gross = $deduction = $tds = 0; ?>
						@foreach($hospital_details as $k => $v)
							<tr>
								<td>{{ $k+1 }}</td>
								<td>{{ $v->float_serial_number }}</td>
								<td>{{ $v->patient_name }}</td>
								<td>{{ $v->district->name }}</td>
								<!-- <td>{{ $v->hospital->name }}</td> -->
								<td>{{ $v->tpa_claim_reference_number }}</td>
								<td>{{ date('d-m-Y', strtotime($v->date_of_admission)) }}</td>
								<td>{{ date('d-m-Y', strtotime($v->date_of_discharge)) }}</td>
								<td>{{ $v->gross_bill }}</td>
								<td>{{ $v->deduction }}</td>
								<td>{{ $v->tds }}</td>
								<td>{{ $v->net_amount }}</td>
								<td>{{ date('d-m-Y', strtotime($v->date_of_payment)) }}</td>
								<td>{{ $v->utr_number }}</td>

								<?php 
									$net_amount += $v->net_amount; 
									
									$gross += $v->gross_bill;
									$deduction += $v->deduction;
									$tds += $v->tds;
								?>

							</tr>
						@endforeach
					</tbody>

					<tfoot>
						<tr>
							<td colspan="7"> Total</td>
							<td>{{ number_format((float)$gross, 2, '.', '') }}</td>
							<td>{{ number_format((float)$deduction, 2, '.', '') }}</td>
							<td>{{ number_format((float)$tds, 2, '.', '') }}</td>
							<td>{{ number_format((float)$net_amount, 2, '.', '') }}</td>
						</tr>
					</tfoot>
				</table>

				<div class="row">
					<div class="col-md-12">
						<a href="{{ route('hospital.pdf.export', $hospital->id) }}" target="_blank"> Export to PDF</a>
					</div>
				</div>
				@else
				<div class="alert alert-warning">
					<h3>NO PAYMENTS FOUND</h3>
				</div>
				@endif
			</div><!-- /.padding-md -->
		</div><!-- /panel -->
	</div>
</div>


@endsection