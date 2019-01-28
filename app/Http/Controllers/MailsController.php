<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FloatFile, App\Models\ClaimFloat;
use App\Master\District;
use App\Master\Hospital;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Carbon, Mail;

class MailsController extends Controller
{
    public function viewFreshFloats(Request $request) {
    	$results = FloatFile::where('mail_time', NULL)->get();
    	return view('float.mail.fresh_floats', compact('results'));
    }


    public function viewFloatHospitals(Request $request, $float_file_id) {
    	$float_file = FloatFile::find($float_file_id);
        //dd($float_file);
    	//$all_hospitals = ClaimFloat::where('float_file_id', $float_file_id)->select('hospital_id', 'date_of_payment', 'mail_sent', 'mail_sent_on', 'id')->distinct()->get();


        $all_hospitals = ClaimFloat::where('float_file_id', $float_file_id)->select('hospital_id')->distinct()->get()->toArray();

        

        $hospitals = Hospital::whereIn('id', $all_hospitals)->get()->toArray();
        //dd($hospitals);

    	

    	return view('float.mail.hospitals', compact('hospitals', 'float_file'));
    }

    public function makeExcel( $float_file_id, $hospital_id) {
        
		$hospital_data = ClaimFloat::where('float_file_id', $float_file_id)
						->where('hospital_id', $hospital_id)
						->with('district', 'hospital')
						->get();

		$arr = [];

		$all_gross = $all_deduction = $all_tds = $all_net = 0;

		$count = count($hospital_data)+1;

		$float_file_name = htmlspecialchars(FloatFile::find($float_file_id)->name);
		$hospital_name = htmlspecialchars(Hospital::find($hospital_id)->name);

		
		$sheetname = $this->clean(str_replace('/', '', substr($float_file_name,0, 10).'_'.substr($hospital_name,0, 20)));

        $hosp_nm = substr($hospital_name,0,20);
		//dd($sheetname);
		//dd(substr($float_file_name,0, 10).'_'.substr($hospital_name,0, 20));

        $total_gross = $total_deduction = $total_tds = $total_net = 0;

		foreach($hospital_data as $k1 => $v1) {

			$gross = $deduction = $tds = $net = 0;

			$gross 		+= (float) $v1->gross_bill;
			$all_gross  += (float) $v1->gross_bill;

			$deduction 	+= (float) $v1->deduction;
			$all_deduction 	+= (float) $v1->deduction;

			$tds 		+= (float) $v1->tds;
			$all_tds 		+= (float) $v1->tds;

			$net 		+= (float) $v1->net_amount;
			$all_net 		+= (float) $v1->net_amount;

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
        
        Excel::create($sheetname, function( $excel) use($arr, $count, $float_file_name, $hosp_nm){
            $excel->sheet('All', function($sheet) use($arr, $count, $float_file_name, $hosp_nm){
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
            

        })->store('xls', public_path('excel/exports'));

        return $sheetname;
    
    }

    public function sendMail(Request $request) {
        $hospital_id = $request->hospital_id;
        $float_file_id = $request->float_file_id;
        $float_file = FloatFile::find($float_file_id);
    	//$email = $request->email;

        $hospital = Hospital::find($hospital_id);

        $emails = $hospital->email;

        $email_arr = explode('/', $emails);

        $email = $email_arr[0];

        $cc = []; 

        if(env('TEST_MAIL') != '') {
            $email = 'nitish.dola@gmail.com';
        }else{
            $cc = ['finance.aaasassam@gmail.com', 'sthapa@mdindia.com'];
        }
        //$email = 'finance.aaasassam@gmail.com';
        //$email = 'nitish.dola@gmail.com';
        
        if($email != ''){

                $hospital_name = ucwords(Hospital::find($hospital_id)->name);

                $sheetname = $this->makeExcel($float_file_id, $hospital_id);

                $payment_advice_file = $float_file->payment_advice_file_path;

                $float_number = $float_file->float_number;
        //dd($float_file->float_number);

                $mail = Mail::send('mail.send_hospital_mail', ['hospital_name' => $hospital_name, 'float_number' => $float_number], function ($message) use($email, $sheetname, $hospital_name,$payment_advice_file)
                {

                    $message->from('finance.aaasassam@gmail.com', 'SHA Assam');

                    $message->to($email);

                    if(!empty($cc)) {
                        $message->cc();
                    }
                    

                    $message->attach(public_path('excel/exports/'.$sheetname.'.xls'), [
                        'as' => $hospital_name.'.xls',
                        'mime' => 'application/vnd.ms-excel'
                    ]);

                    if($payment_advice_file) {
                        $message->attach(public_path($payment_advice_file), [
                            'as' => 'Payment_Advice.pdf',
                            'mime' => 'application/pdf'
                        ]);
                    }

                    

                    $message->subject('Payment Details of '.$hospital_name);

                });

            $float = ClaimFloat::where(['float_file_id' => $float_file_id, 'hospital_id' => $hospital_id])->first();

            $float->mail_sent = 1;
            $float->mail_sent_on = date('Y-m-d H:i:s');
            $float->save();

        
            $float_file_check = ClaimFloat::where('float_file_id', $float_file_id)->where('mail_sent', 1)->count();

            if($float_file_check) {
                $float_file = FloatFile::find($float_file_id);
                $float_file->mail_time = date('Y-m-d H:i:s');
                $float_file->save();
            }
            return 1;
        }else{
            return 'Email not found !';
        }
    }

    private function clean($string) {
    	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }
}
