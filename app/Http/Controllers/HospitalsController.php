<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Master\District;
use App\Master\Hospital;
use DB, Validator, Redirect, Auth, Crypt, Input, Excel, Carbon, Mail;

class HospitalsController extends Controller
{
    public function index() {
    	$results = Hospital::orderBy('name')->get();
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
}
