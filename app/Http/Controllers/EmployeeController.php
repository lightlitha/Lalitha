<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;
//
use App\Models\User;
use App\Models\Employee;
use App\Models\Address;
use App\Models\Contact;
use App\Models\NextOfKin;
// Lalitha
use App\Services\LLRoute\Controller as LLController;

class EmployeeController extends LLController
{
    const ITEM_PER_PAGE = 10;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $employeeQuery = Employee::query();
        $keyword = Arr::get($searchParams, 'keyword', '');
        $is_active = Arr::get($searchParams, 'is_active', '');
        $is_available = Arr::get($searchParams, 'is_available', '');
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);

        if(!empty($is_active) && strlen($is_active) < 2) {
            $employeeQuery->where('is_active',  $is_active);
        }

        if(!empty($is_available && strlen($is_available) < 2)) {
            $employeeQuery->where('is_available',  $is_available);
        }
        
        if (!empty($keyword)) {
            $employeeQuery->where('nickname', 'LIKE', '%' . $keyword . '%');
            $employeeQuery->orWhere('first_name', 'LIKE', '%' . $keyword . '%');
            $employeeQuery->orWhere('last_name', 'LIKE', '%' . $keyword . '%');
            $employeeQuery->orWhere('created_at', 'LIKE', '%' . $keyword . '%');
        }
        $employees = $employeeQuery->paginate($limit);
        return view('pages.employees.browse', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.employees.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::extend('olderThan', function($attribute, $value, $parameters) {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;
            return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        });
        $validator = Validator::make(
            $request->all(),
            [
                'date_of_birth' => 'olderThan:18',
                'first_name' => 'required',
                'last_name' => 'required',
                'nickname' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to add New Employee. Validate your fields please');
        } else {
            $params = $request->all();

            $user = User::create([
                'name' => $params['nickname'],
                'email' => $params['nickname'] . '@example.com',
                'password' => Hash::make('@candys'),
            ]);

            $employee = Employee::create([
                'nickname' => $params['nickname'],
                'first_name' => $params['first_name'],
                'last_name' => $params['last_name'],
                'date_of_birth' => Carbon::parse($params['date_of_birth'])->format('Y-m-d'),
                'user_id' => $user->id
            ]);
            return redirect()->route('employees.show', [$employee]);
            // return redirect()->back()->with('success', 'Successfully Added New Employee');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $tabs = parent::employee_tabs($employee);
        $avatar = empty($employee) ? 
            null : (empty($employee->getFirstMedia('avatar')) ? 
                null : $employee->getFirstMedia('avatar')->getUrl('thumb'));
        $active = 'general';
        return view('pages.employees.read', compact('employee', 'tabs', 'avatar', 'active'));
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
    public function update(Request $request, Employee $employee)
    {
        if ($employee === null) {
            return redirect()->back()->with('failure', 'Failed to find Employee.');
        }
        // if ($employee->isAdmin()) {
        //     return response()->json(['error' => 'Admin can not be modified'], 403);
        // }

        if(!empty($request->file('avatar'))) {
            $status = $this->avatarUpload($request, $employee);
            if(!$status['status']) {
                return redirect()->back()->with('failure', 'Avatar Problem. ' . $status['message']); 
            }
        }
        if(!empty($request->file('image'))) {
            return $this->imageUpload($request, $employee);
        }
        if(!empty($request->file('video'))) {
            return $this->videoUpload($request, $employee);
        }

        $validator = Validator::make($request->all(), $this->getValidationRules(false));
        if ($validator->fails()) {
            return redirect()->back()->with('success', 'Failed to validate Employee. ');
        } else {
            try {
                $employee->nickname = $request->get('nickname');
                $employee->first_name = $request->get('first_name');
                $employee->last_name = $request->get('last_name');
                $employee->id_number = $request->get('id_number');
                $employee->date_of_birth = Carbon::parse($request->get('date_of_birth'))->format('Y-m-d');
                $employee->id_number = $request->get('id_number');
                $employee->passport_number = $request->get('passport_number');
                $employee->nationality = $request->get('nationality');
                $employee->save();
                return redirect()->back()->with('success', 'Updated Employee. ');
            } catch (\Throwable $th) {
                return redirect()->back()->with('success', 'Failed to update Employee. ' . $th);
            }
        }
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
     * @param bool $isNew
     * @return array
     */
    private function getValidationRules($isNew = true)
    {
        Validator::extend('olderThan', function($attribute, $value, $parameters) {
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 13;
            return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        });
        return [
            'date_of_birth' => 'olderThan:18',
            'first_name' => 'required',
            'last_name' => 'required',
            'nickname' =>  $isNew ? 'required|unique:employees' : 'required',
        ];
    }

    /**
     * Upload avatar for employee
     * Spatie
     * @return array
     */
    private function avatarUpload(Request $request, Employee $employee)
    {
        try {
            $file = $request->file('avatar');
            // $employee->last()->delete();
            $employee->addMedia($file)
            ->usingName('Avatar')
            ->usingFileName('Avatar.' . $file->getClientOriginalExtension())
            ->withCustomProperties(['type' => 'avatar'])
            ->toMediaCollection('avatar');

            return ['status' => true];
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => 'Allowed image formats(.png, jpeg)'];
        }
    }

    /**
     * Upload image/'s for employee
     * Spatie
     */
    private function imageUpload(Request $request, Employee $employee)
    {
        $file = $request->file('image');
        $employee->addMedia($file)->toMediaCollection();
    }

    /**
     * Upload video/'s for employee
     * Spatie
     */
    private function videoUpload(Request $request,  Employee $employee)
    {
        $file = $request->file('video');
        $employee->addMedia($file)->toMediaCollection();
    }
}
