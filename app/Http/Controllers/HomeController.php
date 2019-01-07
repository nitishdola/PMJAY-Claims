<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FloatFile, App\Models\ClaimFloat;
use App\Master\District;
use App\Master\Hospital;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Carbon;

class HomeController extends Controller
{
    public function index() {
    	$results = FloatFile::orderBy('upload_time', 'DESC')->paginate(300);
    	return view('home', compact('results'));
    }
}
