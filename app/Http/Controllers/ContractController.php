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
        $contractfile = empty($contract) ? 
            null : (empty($contract->getFirstMedia('contract')) ? 
                null : $contract->getFirstMedia('contract')->getUrl()); 
        $active = 'contract';
        return view('pages.contract.add-edit', compact('employee', 'contract', 'contractfile', 'tabs', 'active'));
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
            $cont->is_signed = empty($contract['is_signed']) ? true : false;
            $cont->is_permanent = empty($contract['is_permanent']) ? true : false;
            $cont->is_active = empty($contract['is_active']) ? true : false;
            $cont->note = empty($contract['note']) ? null : $contract['note'];
            $cont->save();
        } else {
            $cont = Contract::create([
                'begin' => empty($contract['begin']) ? null : Carbon::parse($contract['begin'])->format('Y-m-d'),
                'end' => empty($contract['end']) ? null : Carbon::parse($contract['end'])->format('Y-m-d'),
                'is_signed' => empty($contract['is_signed']) ? true : false,
                'is_permanent' => empty($contract['is_permanent']) ? true : false,
                'is_active' => empty($contract['is_active']) ? true : false,
                'note' => empty($contract['note']) ? null : $contract['note'],
                'employee_id' => $contract['e_id'],
            ]);
        }
        if(!empty($request->file('contract'))) {
            $status = $this->contractUpload($request, $cont);
            if(!$status['status']) {
                return redirect()->back()->with('failure', 'Contract Problem. ' . $status['message']); 
            }
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

    /**
     * Upload Contract File for employee
     * Spatie
     * @return array
     */
    private function contractUpload(Request $request, Contract $contract)
    {
        try {
            $file = $request->file('contract');
            $contract->addMedia($file)
            ->usingName('Contract')
            ->usingFileName('Contract.' . $file->getClientOriginalExtension())
            ->withCustomProperties(['type' => 'contract'])
            ->toMediaCollection('contract');

            return ['status' => true];
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => $th . 'Only Office file formats Allowed (Word, LibreWriter, PDF)'];
        }
    }
}
