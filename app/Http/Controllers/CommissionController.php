<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use Illuminate\Support\Arr;
use Validator;

class CommissionController extends Controller
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
        
        $commissionQuery = Commission::query();
        
        if (!empty($keyword)) {
            $commissionQuery->where('name', 'LIKE', '%' . $keyword . '%');
            $commissionQuery->orWhere('percentage', 'LIKE', '%' . $keyword . '%');
            $commissionQuery->orWhere('description', 'LIKE', '%' . $keyword . '%');
        }

        $commissions = $commissionQuery->paginate($limit);
        return view('pages.commissions.browse', compact('commissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.commissions.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'percentage' => ['required']
            ]
        );
    
        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to add New Commission. Validate your fields please');
        } else {
            $params = $request->all();
            $commission = Commission::create([
                'name' => $params['name'],
                'percentage' => $params['percentage'],
                'is_active' => empty($params['is_active']) ? 
                                    false : ($params['is_active'] == 'on') ? 
                                        true : false,
                'description' => empty($params['description']) ? null : $params['description'],
            ]);
            return redirect()->back()->with('success', 'Successfully Added New Commission');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        return view('pages.commissions.read', compact('commission'));
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
    public function update(Request $request, Commission $commission)
    {
        if ($commission === null) {
            return redirect()->back()->with('failure', 'Commission not found');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'percentage' => ['required']
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'problem validating Commission. validate your fields');
        } else {
            $params = $request->all();
            $commission->name = $params['name'];
            $commission->percentage = $params['percentage'];
            $commission->is_active = 
                empty($params['is_active']) ? 
                    false : ($params['is_active'] == 'on') ? 
                        true : false;
            $commission->description = empty($params['description']) ? null : $params['description'];
            $commission->save();
        }
        return redirect()->back()->with('success', 'Commission updated');
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
