<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Master\District;
use App\Master\Hospital;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Carbon, Mail, PDF;
use App\Models\FloatFile, App\Models\ClaimFloat;
class HospitalsController extends Controller
{
    public function index(Request $request) {
        $where['status'] = 1;

        if($request->hospital_type) {
            $where['hospital_type'] = $request->hospital_type;
        }

    	$results = Hospital::where($where)->orderBy('name')->get();
    	return view('master.hospitals.index', compact('results'));
    }

    public function edit($id) {
    	$hospital = Hospital::findorFail($id);
    	return view('master.hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, $id) {
    	$hospital = Hospital::findorFail($id);

    	$hospital->fill($request->all());

    	$hospital->save();

    	return Redirect::route('hospital.index')->with(['message' => 'Updated Successfully !', 'alert-class' => 'alert-success']);
    }

    public function viewHospitalDetails(Request $request, $id) {
        $where = [];
        $hospital = Hospital::find($id);
        $where['hospital_id'] = $id;
        $hospital_details = ClaimFloat::where($where)->with('hospital', 'district')->orderBy('date_of_payment', 'ASC')->get();
        return view('master.hospitals.details', compact('hospital_details', 'hospital'));
    }

    public function exportToPdf(Request $request, $id) {
        $where = [];
        $hospital = Hospital::find($id);
        $where['hospital_id'] = $id;
        $hospital_details = ClaimFloat::where($where)->with('hospital', 'district')->orderBy('date_of_payment', 'ASC')->get();


        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('pdf.hospital', compact('hospital', 'hospital_details'));
        // If you want to store the generated pdf to the server then you can use the store function
        //$pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function
        return $pdf->download(str_replace(' ', '-', strtolower($hospital->name.'_'.date('d_m_Y_h_i_s'))).'.pdf');
    }


}
