<!DOCTYPE html>
<html>
<head>
	<style type = "text/css">
		 table {
		    border-collapse: collapse;
		    font-size: 10px; 
		    color: #555;
		    font-family: "Trebuchet MS";
		    font-weight: 700
		  }
		  th, td {
		    border: 1px solid #ddd;
		    padding: 2px;
		    text-align: left;
		  }
	</style>
</head>
<body>
<table>
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
			<th>Remarks</th>
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
				<td>{{ $v->remarks }}</td>

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
			<td colspan="2">&nbsp;</td>
		</tr>
	</tfoot>
</table>
</body>
</html>

			