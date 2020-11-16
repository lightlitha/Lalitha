<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Arr;
use Validator;
//
use App\Models\User;
use App\Models\Employee;

class RoleController extends Controller
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
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');
        
        $rolesQuery = Role::query();
        
        if (!empty($keyword)) {
            $rolesQuery->where('name', 'LIKE', '%' . $keyword . '%');
        }

        $permissions = Permission::all();

        $roles = $rolesQuery->paginate($limit);
        return view('pages.roles.browse', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request
        ) {
            try {
                if(!empty($request->get('role_name'))) {
                    $role = Role::create(['name' => $request->get('role_name')]);
                    return redirect()->back()->with('success', 'Successfully Added New Role');
                }
                if(!empty($request->get('permission_name'))) {
                    $role = Permission::create(['name' => $request->get('permission_name')]);
                    return redirect()->back()->with('success', 'Successfully Added Permission');
                }
                if(!empty($request->get('role_permissions'))) {
                    $role = Role::find($request->get('role_id'));
                    if(!empty($role)) {
                        $role->syncPermissions($request->get('role_permissions'));
                        return redirect()->back()->with('success', 'Successfully Added Permission');
                    }
                    return redirect()->back()->with('failure', 'Could not find role. ' . $th);
                }
                
            } catch (\Throwable $th) {
                return redirect()->back()->with('failure', 'Failed to add New Item. ' . $th);
            }
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $role)
    {
        return view('pages.roles.read', compact('role'));
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
     * 
     */
    public function update_access_control(Request $request, Employee $employee)
    {
        $user = User::find($employee->id);
        if(empty($user)) {
            return redirect()->back()->with('failure', 'Failed, Employee, not in the users table');
        }
        $params = $request->all();
        echo print_r($params);
        if(!empty($params['permissions'])) {
            $user->syncPermissions($params['permissions']);
        }
        if(!empty($params['roles'])) {
            $user->syncRoles($params['roles']);
        }
        return redirect()->back()->with('success', 'Updated, Employee Access Control List');
    }

    /**
     * 
     */
    public function fetch_access_control(Employee $employee)
    {
        $user = User::find($employee->id);
        if(empty($user)) {
            return redirect()->back()->with('failure', 'Failed, Employee, not in the users table');
        }
        $active = 'acl';
        $tabs = parent::navigate_model($employee, 'employee_tabs');
        $avatar = (empty($employee->getFirstMedia('avatar')) ? 
                null : $employee->getFirstMedia('avatar')->getUrl('thumb'));
        $permissions = Permission::all();
        $roles = Role::all();
        return view('pages.employees.roles', compact('permissions', 'roles', 'employee', 'tabs', 'avatar', 'user', 'active'));
    }
}
