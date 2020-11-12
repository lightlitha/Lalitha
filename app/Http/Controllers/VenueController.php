<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use Illuminate\Support\Arr;
use Validator;

class VenueController extends Controller
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
        
        $venueQuery = Venue::query();
        
        if (!empty($keyword)) {
            $venueQuery->where('name', 'LIKE', '%' . $keyword . '%');
            $venueQuery->orWhere('tag', 'LIKE', '%' . $keyword . '%');
            $venueQuery->orWhere('description', 'LIKE', '%' . $keyword . '%');
        }

        $venue = $venueQuery->paginate($limit);
        return view('pages.venue.browse', compact('venue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.venue.add');
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
                'name' => ['required']
            ]
        );
    
        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to add New Venue. Validate your fields please');
        } else {
            $params = $request->all();
            $venue = venue::create([
                'name' => $params['name'],
                'is_active' => $params['is_active'],
                'description' => $params['description'],
            ]);
            return redirect()->back()->with('success', 'Successfully Added New Venue');
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        return view('pages.venue.read', compact('venue'));
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
    public function update(Request $request, Venue $venue)
    {
        if ($venue === null) {
            return redirect()->back()->with('failure', 'venue not found');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required']
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'problem validating venue. validate your fields');
        } else {
            $params = $request->all();
            $venue->name = $params['name'];
            $venue->is_active = $params['is_active'];
            $venue->description = $params['description'];
            $venue->save();
        }
        return redirect()->back()->with('success', 'Venue updated');
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
