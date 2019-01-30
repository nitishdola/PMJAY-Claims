<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FloatFile, App\Models\ClaimFloat;
use App\Master\District;
use App\Master\Hospital;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Carbon;

class UpdateController extends Controller
{
    public function update_data() {
    	return view('update.data');
    }

    public function save_data(Request $request) {
    	$path = $request->file('data_file')->getRealPath();
    	$data = Excel::load($path, function($reader) {})->get();
    	//dd($data);
		for($i = 0; $i < count($data); $i++) {
	    	foreach($data[$i] as $k => $v) { //dd($v);
	    		if(isset($v['tpa_claim_reference_no'])){
		    		$tpa_claim_reference_number = $v['tpa_claim_reference_no'];

		    		$claim_floats = ClaimFloat::where('tpa_claim_reference_number', $tpa_claim_reference_number)->get();

		    		foreach($claim_floats as $k1 => $v1) {
		    			$claim_float = ClaimFloat::whereId($v1->id)->first();

		    			//dump($v);

		    			$utr = $v['utr_number'];
		    			$remarks = $v['remarks'];
		    			//dd('die');
		    			$claim_float->utr_number = $utr;
		    			$claim_float->remarks = $remarks;

		    			$claim_float->save();
		    		}
				}else{
					echo $i.' sheet error ';
					exit;
				}
	    	}
	    }


    	return Redirect::route('update_data')->with(['message' => 'Upload Successfull !', 'alert-class' => 'alert-success']);
    }
}
