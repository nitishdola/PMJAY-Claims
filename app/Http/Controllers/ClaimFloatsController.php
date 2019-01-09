<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FloatFile, App\Models\ClaimFloat;
use App\Master\District;
use App\Master\Hospital;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Carbon, Mail;

class ClaimFloatsController extends Controller
{
    public function edit($id) { 
    	$float = ClaimFloat::find($id);
    	$hospitals 	= Hospital::where('status', 1)->orderBy('name')->pluck('name', 'id');
    	return view('float.edit', compact('float', 'hospitals'));
    }

    public function update(Request $request, $id) {
    	$float = ClaimFloat::find($id);
    	$data = $request->all();
    	$float->fill($data);

    	$float->save();

    	return Redirect::route('home')->with(['message' => 'Updated successfully !', 'alert-class' => 'alert-success']);
    } 
}
