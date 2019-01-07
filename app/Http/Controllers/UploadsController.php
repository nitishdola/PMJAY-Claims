<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FloatFile, App\Models\ClaimFloat;
use App\Master\District;
use App\Master\Hospital;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Carbon;

class UploadsController extends Controller
{
    public function uploadData() {
    	return view('float.upload');
    }

    public function saveAllData(Request $request) {
    	$path = $request->file('data_file')->getRealPath();
    	$data = Excel::load($path, function($reader) {})->get();

    	/*dump(count($data));
    	dd($data);*/
    	DB::beginTransaction();
    	$c = 0;
    	$filename = pathinfo($request->file('data_file')->getClientOriginalName(), PATHINFO_FILENAME);

    	//insert filename
    	$filename_date = [];
    	$filename_date['name'] 			= $filename;
    	$filename_date['float_number'] 	= trim($request->float_number);
    	$filename_date['upload_time'] 	= date('Y-m-d H:i:s');

    	//Upload file if any

    	if ($request->hasFile('payment_advice_file')) {
            if ($request->file('payment_advice_file')->isValid()){
                $file           = $request->file('payment_advice_file');
                $payment_advice_file_name       = str_replace(' ', '_', $filename).'_payment_advice_'.strtolower(uniqid()).'.'.$file->getClientOriginalExtension();
                $destinationPath = 'payment_advice';
                $file->move($destinationPath,$payment_advice_file_name);
                $filename_date['payment_advice_file_path']  = $destinationPath.'/'.$payment_advice_file_name;
            }
        }

    	$check = FloatFile::whereName($filename)->count();

    	if($check) {
    		return Redirect::back()->with(['message' => 'File '. $filename.' already uploaded', 'alert-class' => 'alert-danger']);
    		exit;
    	}

    	$float_file = FloatFile::create($filename_date);

    	for($i = 0; $i < count($data); $i++) {
	    	foreach($data[$i] as $k => $v) {
	    		if($v['hospital_name'] != '') {

	    			$utr = '';
	    			if(isset($v['utr_no.'])) {
	    				$utr = $v['utr_no.'];
	    			}

		    		$hospital_name 	= trim($v['hospital_name']);
		    		$hospital_name 	= trim(str_replace('-PMJAY', '', $hospital_name));
		    		$hospital_name 	= trim(str_replace('- PMJAY', '', $hospital_name));
		    		$hospital_name 	= trim(str_replace('-pmjay', '', $hospital_name));

		    		if($v['hospital_name'] != 'Aditya Diagnostic & Hospital Dibrugarh') {
		    			$hospital_name 	= trim(str_replace('& Hospital', '', $hospital_name));
		    		}
		    		

		    		if($hospital_name == 'Holly Spirit Hospital') {
		    			$hospital_name = 'Holy Spirit Hospital';
		    		}


		    		if($hospital_name == 'Dims has changed to GATE Hospital') {
		    			$hospital_name = 'GATE Hospital';
		    		}

		    		$hospital = Hospital::where('name', 'like', '%' . $hospital_name . '%')->first();

		    		$district = District::whereName(trim($v['beneficiary_district']))->first();

		    		if($hospital) {
		    			
		    			$float_data['float_file_id'] 		= $float_file->id;
		    			$float_data['float_serial_number'] 	= (int) $v['float_sl._no'];
		    			$float_data['patient_name'] 		= $v['patient_name'];
		    			if($district):
		    			$float_data['beneficiary_district_id'] 			= $district->id;
		    			endif;

		    			$float_data['hospital_id'] 			= $hospital->id;
		    			$float_data['tpa_claim_reference_number'] 			= $v['tpa_claim_reference_no'];
		    			$float_data['date_of_admission'] 	= date('Y-m-d', strtotime(str_replace('/', '-', $v['date_of_admission'])));

		    			$float_data['date_of_discharge'] 	= date('Y-m-d', strtotime(str_replace('/', '-', $v['date_of_discharge'])));
		    			
		    			if(isset($v['gross_bill'])) {
		    				$float_data['gross_bill'] 			= (float) $v['gross_bill'];
		    			}else{
		    				$float_data['gross_bill'] 			= (float) $v['gross_amount'];
		    			}
		    			
		    			$float_data['deduction'] 			= (float) $v['deduction_rs'];
		    			$float_data['tds'] 					= (float) $v['tds_amount_10_rs'];
		    			$float_data['net_amount'] 			= (float) $v['net_amount'];

		    			$float_data['date_of_payment'] 		= Carbon::parse($v['dop'])->format('Y-m-d');
		    			$float_data['utr_number'] 			= $utr;

		    			$validator = Validator::make($float_data, ClaimFloat::$rules);
		    			if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();

		    			ClaimFloat::create($float_data);
			    		
		    			$c++;
		    		}else{
	    				echo '<br>'.$hospital_name.' not found';
	    			}
		    	}
	    		
		    	
	    	}
	    }
    	DB::commit();

    	return Redirect::route('home')->with(['message' => 'Upload Successfull !', 'alert-class' => 'alert-success']);
    }
}
