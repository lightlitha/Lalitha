<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Contact;
use Validator;

class ContactController extends Controller
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
        $contact = Contact::where('employee_id', $employee->id)->first();
        $tabs = parent::navigate_model($employee, 'employee_tabs');
        $active = 'contact';
        return view('pages.contact.add-edit', compact('employee', 'contact', 'tabs', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = $request->all();
        $cont = Contact::where('employee_id', $contact['e_id'])->first();

        $validator = Validator::make(
            $request->all(),
            [
                'cellphone' => 'required'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to validate Contacts. Validate your fields please');
        }
        if(!empty($cont)) {
            $cont->cellphone = $contact['cellphone'];
            $cont->home = empty($contact['home']) ? null : $contact['home'];
            $cont->telephone = empty($contact['telephone']) ? null : $contact['telephone'];
            $cont->work = empty($contact['work']) ? null : $contact['work'];
            $cont->other = empty($contact['other']) ? null : $contact['other'];
            $cont->save();
        } else {
            $contC = Contact::create([
                'cellphone' => $contact['cellphone'],
                'home' => empty($contact['home']) ? null : $contact['home'],
                'telephone' => empty($contact['telephone']) ? null : $contact['telephone'],
                'work' => empty($contact['work']) ? null : $contact['work'],
                'other' => empty($contact['other']) ? null : $contact['other'],
                'employee_id' => $contact['e_id'],
            ]);
        }
        return redirect()->back()->with('success', 'Successfully Updated Contacts');
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
