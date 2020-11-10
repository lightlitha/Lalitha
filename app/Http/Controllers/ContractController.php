<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Contract;
use Carbon\Carbon;
use Validator;

class ContractController extends LLController
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
        $contract = Contract::where('employee_id', $emp_id)->first();
        $tabs = parent::employee_tabs($employee);
        $active = 'contract';
        return view('pages.contract.add-edit', compact('employee', 'contract', 'tabs', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contract = $request->all();
        $cont = Contract::where('employee_id', $contract['e_id'])->first();

        $validator = Validator::make(
            $request->all(),
            [
                'e_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to validate Contract. Validate your fields please');
        }

        if(!empty($cont)) {
            $cont->begin = empty($contract['begin']) ? null : Carbon::parse($contract['begin'])->format('Y-m-d');
            $cont->end = empty($contract['end']) ? null : Carbon::parse($contract['end'])->format('Y-m-d');
            $cont->is_signed = ($contract['is_signed'] == 'on') ? true : false;
            $cont->is_permanent = ($contract['is_permanent'] == 'on') ? true : false;
            $cont->is_active = ($contract['is_active'] == 'on') ? true : false;
            $cont->note = empty($contract['note']) ? null : $contract['note'];
            $cont->save();
        } else {
            $nextOK = Contract::create([
                'begin' => empty($contract['begin']) ? null : Carbon::parse($contract['begin'])->format('Y-m-d'),
                'end' => empty($contract['end']) ? null : Carbon::parse($contract['end'])->format('Y-m-d'),
                'is_signed' => ($contract['is_signed'] == 'on') ? true : false,
                'is_permanent' => ($contract['is_permanent'] == 'on') ? true : false,
                'is_active' => ($contract['is_active'] == 'on') ? true : false,
                'note' => empty($contract['note']) ? null : $contract['note'],
                'employee_id' => $contract['e_id'],
            ]);
        }
        return redirect()->back()->with('success', 'Successfully Updated Contract');
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
