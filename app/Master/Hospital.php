<?php

namespace App\Master;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    protected $fillable = array(
    	'name', 'bed_strength', 'hospital_type', 'address', 'email', 'phone_number', 'district_id', 'is_nabh'

    );

    protected $table    	= 'hospitals';
    protected $guarded   	= ['_token'];
    public static $rules 	= [
    	'name' 					=> 'required',
    	'bed_strength' 			=> 'required',
    	'hospital_type' 		=> 'required',
    	'address' 				=> 'required',
	];

    public function district()
    {
      return $this->belongsTo('App\Models\Master\District', 'district_id');
    }
}
