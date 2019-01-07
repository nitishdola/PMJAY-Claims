<?php

namespace App\Master;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = array(
    	'name', 'number_of_beneficiary'

    );

    protected $table    = 'districts';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'name' 			=> 'required',
    	'number_of_beneficiary' => 'required|numeric',
	];
}
