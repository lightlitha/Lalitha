<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\NextOfKin;
use Validator;

class NextOfKinController extends Controller
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
    public function create(Employee $employee)
    {
        $family = NextOfKin::where('employee_id', $employee->id)->first();
        $tabs = parent::navigate_model($employee, 'employee_tabs');
        $active = 'family';
        return view('pages.family.add-edit', compact('employee', 'family', 'tabs', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nok = $request->all();
        $next = NextOfKin::where('employee_id', $nok['e_id'])->first();

        $validator = Validator::make(
            $request->all(),
            [
                'cellphone' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to validate Next Of Kin. Validate your fields please');
        }

        if(!empty($next)) {
            $next->cellphone = $nok['cellphone'];
            $next->first_name = $nok['first_name'];
            $next->last_name = $nok['last_name'];
            $next->other_phone = empty($nok['other_phone']) ? null : $nok['other_phone'];
            $next->save();
        } else {
            $nextOK = NextOfKin::create([
                'cellphone' => $nok['cellphone'],
                'first_name' => $nok['first_name'],
                'last_name' => $nok['last_name'],
                'other_phone' => empty($nok['other_phone']) ? null : $nok['other_phone'],
                'employee_id' => $nok['e_id'],
            ]);
        }
        return redirect()->back()->with('success', 'Successfully Updated Next of Kin');
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
