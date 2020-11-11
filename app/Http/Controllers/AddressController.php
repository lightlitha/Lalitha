<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Employee;
use Validator;
// Lalitha
use App\Services\LLRoute\Controller as LLController;

class AddressController extends LLController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $emp_id = $request->get('emp_id');
        $employee = Employee::find($emp_id);
        $address = Address::where('employee_id', $emp_id)->first();
        $tabs = parent::employee_tabs($employee);
        $active = 'address';
        return view('pages.address.add-edit', compact('employee', 'address', 'tabs', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $address = $request->all();
        $addr = Address::where('employee_id', $address['e_id'])->first();

        $validator = Validator::make(
            $request->all(),
            [
                'country' => 'required',
                'line1' => 'required',
                'city' => 'required',
                'suburb' => 'required',
                'zipcode' => 'zipcode',
                'e_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to validate Address. Validate your fields please');
        }

        if(!empty($addr)) {
            $addr->country = $address['country'];
            $addr->line1 = $address['line1'];
            $addr->line2 = empty($address['line2']) ? null : $address['line2'];
            $addr->suburb = empty($address['suburb']) ? null : $address['suburb'];
            $addr->city = $address['city'];
            $addr->zipcode = $address['zip_code'];
            $addr->save();
        } else {
            $add = Address::create([
                'city' => $address['city'],
                'country' => $address['country'],
                'line1' => $address['line1'],
                'line2' => empty($address['line2']) ? null : $address['line2'],
                'suburb' => empty($address['suburb']) ? null : $address['suburb'],
                'city' => $address['city'],
                'zipcode' => $address['zip_code'],
                'employee_id' => $address['e_id'],
            ]);
        }
        return redirect()->back()->with('success', 'Successfully Updated Address');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
