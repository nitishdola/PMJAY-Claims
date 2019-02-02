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


    public function disable($id) {
        $hospital = Hospital::findorFail($id);
        $hospital->status = 0;
        $hospital->save();
        return Redirect::route('hospital.index')->with(['message' => 'Removed Successfully !', 'alert-class' => 'alert-success']);
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

    public function exportToExcel(Request $request, $id) {
        $where = [];
        $hospital = Hospital::find($id);
        $where['hospital_id'] = $id;
        $hospital_data = ClaimFloat::where($where)->with('hospital', 'district')->orderBy('date_of_payment', 'ASC')->get();

        $arr = [];

        $all_gross = $all_deduction = $all_tds = $all_net = 0;

        $count = count($hospital_data)+1;

        $hospital_name = htmlspecialchars(Hospital::find($id)->name);

        
        $sheetname = str_replace('/', '', substr($hospital_name,0, 20));

        $hosp_nm = substr($hospital_name,0,20);
        //dd($sheetname);
        //dd(substr($float_file_name,0, 10).'_'.substr($hospital_name,0, 20));

        $total_gross = $total_deduction = $total_tds = $total_net = 0;

        foreach($hospital_data as $k1 => $v1) {

            $gross = $deduction = $tds = $net = 0;

            $gross      += (float) $v1->gross_bill;
            $all_gross  += (float) $v1->gross_bill;

            $deduction  += (float) $v1->deduction;
            $all_deduction  += (float) $v1->deduction;

            $tds        += (float) $v1->tds;
            $all_tds        += (float) $v1->tds;

            $net        += (float) $v1->net_amount;
            $all_net        += (float) $v1->net_amount;

            $arr[$k1]['Sl No'] = $k1+1;
            $arr[$k1]['Float Sl. No'] = $v1->float_serial_number;
            $arr[$k1]['Patient Name'] = $v1->patient_name;
            $arr[$k1]['Beneficiary District'] = $v1->district->name;
            $arr[$k1]['Hospital Name'] = $v1->hospital->name;
            $arr[$k1]['TPA Claim reference No'] = $v1->tpa_claim_reference_number;
            $arr[$k1]['Date of Admission'] = date('d-m-Y', strtotime($v1->date_of_admission));
            $arr[$k1]['Date of Discharge'] = date('d-m-Y', strtotime($v1->date_of_discharge));
            $arr[$k1]['Gross Bill'] = $gross;

            if($deduction == ''){ 
                $dd = 0; 
            }else{ 
                $dd = $deduction; 
            }
            $arr[$k1]['Deduction (Rs)'] = (float) number_format((float)$dd, 2, '.', '');
            $arr[$k1]['TDS Amount 10% (Rs)'] = (float) number_format((float)$tds, 2, '.', '');
            $arr[$k1]['Net Amount'] = (float) number_format((float)$net, 2, '.', '');
            $arr[$k1]['Date of Payment'] = date('d-m-Y', strtotime($v1->date_of_payment));
            $arr[$k1]['UTR Number'] = $v1->utr_number;
            $arr[$k1]['Remarks'] = $v1->remarks;

            $total_gross += $gross;
            $total_deduction += $dd;
            $total_tds += $tds;
            $total_net += $net;
        }


            $arr[$k1+1]['Sl No'] = '';
            $arr[$k1+1]['Float Sl. No'] = '';
            $arr[$k1+1]['Patient Name'] = '';
            $arr[$k1+1]['Beneficiary District'] = '';
            $arr[$k1+1]['Hospital Name'] ='';
            $arr[$k1+1]['TPA Claim reference No'] = '';
            $arr[$k1+1]['Date of Admission'] = '';
            $arr[$k1+1]['Date of Discharge'] = 'TOTAL';
            $arr[$k1+1]['Gross Bill'] = (float) number_format((float)$total_gross, 2, '.', '');
            $arr[$k1+1]['Deduction (Rs)'] = (float) number_format((float)$total_deduction, 2, '.', '');
            $arr[$k1+1]['TDS Amount 10% (Rs)'] = (float) number_format((float)$total_tds, 2, '.', '');
            $arr[$k1+1]['Net Amount'] = (float) number_format((float)$total_net, 2, '.', '');
            $arr[$k1+1]['Date of Discharge'] = '';
        
        Excel::create($sheetname, function( $excel) use($arr, $count, $hosp_nm){
            $excel->sheet('All', function($sheet) use($arr, $count, $hosp_nm){
              $sheet->setTitle($hosp_nm);

            $sheet->cells('A'.($count+1).':O1'.($count+1), function($cells) {
                $cells->setFontWeight('bold');
            });

            $sheet->cells('A1:O1', function($cells) {
                $cells->setFontWeight('bold');
            });


            $sheet->setWidth(array(
                'A'     =>  5,
                'B'     =>  10,
                'C'     =>  30,
                'D'     =>  25,
                'E'     =>  18,
                'F'     =>  18,
                'G'     =>  18,
                'H'     =>  10,
                'I'     =>  10,
                'J'     =>  10,
                'K'     =>  10,
                'L'     =>  10,
                'M'     =>  15,
                'N'     =>  15,
                'O'     =>  30,
            ));
            $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('B1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('C1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('E1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('H1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('I1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('J1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('K1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('L1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('M1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('N1')->getAlignment()->setWrapText(true);
            $sheet->getStyle('O1')->getAlignment()->setWrapText(true);
              
            
            $sheet->row(1, function($row) { $row->setBackground('#B5DF6B'); });

            $sheet->row(($count+1), function($row) { $row->setBackground('#F9F116'); });

            $range = "A1:O".($count+2);
            //$sheet->setBorder($range, 'thin');

            $sheet->setAllBorders('thin');

            $sheet->fromArray($arr, null, 'A1', false, true);


            });
            

        })->download('xls');
    }

    public function create() {
        $districts    = District::whereStatus(1)->orderBy('name')->pluck('name', 'id');
        return view('master.hospitals.create', compact('districts'));
    }

    public function save(Request $request) {
        $data = $request->all();

        if($add = Hospital::create($data)) {
            return Redirect::route('hospital.index')->with(['message' => 'Hospital Added Successfully !', 'alert-class' => 'alert-success']);
        }
    }


}
