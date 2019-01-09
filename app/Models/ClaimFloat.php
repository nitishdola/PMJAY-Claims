<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimFloat extends Model
{
    protected $fillable = array(
    	'float_file_id', 'float_serial_number', 'patient_name', 'beneficiary_district_id', 'hospital_id', 'tpa_claim_reference_number', 'date_of_admission', 'date_of_discharge', 'gross_bill', 'deduction', 'tds', 'net_amount', 'date_of_payment','utr_number', 'remarks'

    );

    protected $table    = 'floats';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'float_file_id' 	=> 'required|exists:float_files,id',
    	'float_serial_number' 		=> 'required',
    	'patient_name' 	=> 'required',
    	'beneficiary_district_id' 	=> 'required|exists:districts,id',
    	'hospital_id' 	=> 'required|exists:hospitals,id',
    	'tpa_claim_reference_number' 	=> 'required',
    	
    	'date_of_admission' 	=> 'required',
    	'date_of_discharge' 	=> 'required',
    	'gross_bill' 	=> 'required',
    	'deduction' 	=> 'required',
    	'tds' 	=> 'required',
    	'net_amount' 	=> 'required',
    	'date_of_payment' 	=> 'required',
	];

	public function district()
    {
      return $this->belongsTo('App\Master\District', 'beneficiary_district_id');
    }

    public function float_file()
    {
      return $this->belongsTo('App\Models\ClaimFloat', 'float_file_id');
    }

    public function hospital()
    {
      return $this->belongsTo('App\Master\Hospital', 'hospital_id');
    }
}
