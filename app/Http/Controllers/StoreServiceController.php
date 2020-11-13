<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreService;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Validator;

class StoreServiceController extends Controller
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
        
        $storeServiceQuery = StoreService::query();
        
        if (!empty($keyword)) {
            $storeServiceQuery->where('name', 'LIKE', '%' . $keyword . '%');
            $storeServiceQuery->orWhere('price', 'LIKE', '%' . $keyword . '%');
            $storeServiceQuery->orWhere('duration', 'LIKE', '%' . $keyword . '%');
            $storeServiceQuery->orWhere('sku', 'LIKE', '%' . $keyword . '%');
            $storeServiceQuery->orWhere('tag', 'LIKE', '%' . $keyword . '%');
            $storeServiceQuery->orWhere('description', 'LIKE', '%' . $keyword . '%');
        }

        $store_services = $storeServiceQuery->paginate($limit);
        return view('pages.store_services.browse', compact('store_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.store_services.add');
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
                'sku' => ['required'],
                'name' => ['required'],
                'price' => ['required'],
                'duration' => ['required'],
            ]
        );
    
        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'Failed to add New Store Service. Validate your fields please');
        } else {
            $params = $request->all();
            $storeService = StoreService::create([
                'sku' => $params['sku'],
                'name' => $params['name'],
                'price' => $params['price'],
                'duration' =>  Carbon::parse($params['duration'])->format('H:i:s'),
                'cost' => empty($params['cost']) ? 0 : $params['cost'],
                'delay_time' => empty($params['delay_time']) ? null : Carbon::parse($params['delay_time'])->format('H:i:s'),
                'tag' => empty($params['tag']) ? null : $params['tag'],
                'is_active' => empty($params['is_active']) ? 
                                false : ($params['is_active'] == 'on') ? 
                                    true : false,
                'description' => empty($params['description']) ? null : $params['description'],
            ]);
            if(!empty($request->file('picture'))) {
                $status = $this->pictureUpload($request, $storeService);
                if(!$status['status']) {
                    return redirect()->back()->with('failure', 'Service Added Successfully but Picture has a problem. ' . $status['message']); 
                }
            }
            return redirect()->back()->with('success', 'Successfully Added New Store Service');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StoreService $store_service)
    {
        $picture = empty($store_service) ? 
        null : (empty($store_service->getFirstMedia('picture')) ? 
            null : $store_service->getFirstMedia('picture')->getUrl('thumb'));

        return view('pages.store_services.read', compact('store_service', 'picture'));
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
    public function update(Request $request, StoreService $storeService)
    {
        if ($storeService === null) {
            return redirect()->back()->with('failure', 'Store Service not found');
        }

        if(!empty($request->file('picture'))) {
            $status = $this->pictureUpload($request, $storeService);
            if(!$status['status']) {
                return redirect()->back()->with('failure', 'Picture Problem. ' . $status['message']); 
            }
        }

        $validator = Validator::make(
            $request->all(),
            [
                'sku' => ['required'],
                'name' => ['required'],
                'price' => ['required'],
                'duration' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'problem validating Store Service. validate your fields');
        } else {
            $params = $request->all();
            $storeService->sku = $params['sku'];
            $storeService->name = $params['name'];
            $storeService->price = $params['price'];
            $storeService->duration = Carbon::parse($params['duration'])->format('H:i:s');
            $storeService->cost = empty($params['cost']) ? 0 : $params['cost'];
            $storeService->delay_time = empty($params['delay_time']) ? null : Carbon::parse($params['delay_time'])->format('H:i:s');
            $storeService->tag = empty($params['tag']) ? null : $params['tag'];
            $storeService->is_active = 
                empty($params['is_active']) ? 
                    false : ($params['is_active'] == 'on') ? 
                        true : false;
            $storeService->description =  empty($params['description']) ? null : $params['description'];
            $storeService->save();
        }
        return redirect()->back()->with('success', 'Store Service updated');
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
     * Upload avatar for employee
     * Spatie
     * @return array
     */
    private function pictureUpload(Request $request, StoreService $storeService)
    {
        try {
            $file = $request->file('picture');
            // $employee->last()->delete();
            $storeService->addMedia($file)
            ->usingName('service-picture')
            ->usingFileName('service-picture.' . $file->getClientOriginalExtension())
            ->withCustomProperties(['type' => 'service-picture'])
            ->toMediaCollection('picture');

            return ['status' => true];
        } catch (\Throwable $th) {
            return ['status' => false, 'message' => 'Allowed image formats(.png, jpeg)'];
        }
    }
}
