<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloatFile extends Model
{
    protected $fillable = array(
    	'name', 'upload_time', 'mail_time', 'float_number', 'payment_advice_file_path'

    );

    protected $table    = 'float_files';
    protected $guarded   = ['_token'];
    public static $rules = [
    	'name' 		      => 'required',
    	'float_number' 	  => 'required',
    	'upload_time'     => 'required',
	];
}
