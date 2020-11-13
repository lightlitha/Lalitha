<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Arr;
use Validator;


class PaymentMethodController extends Controller
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
        
        $paymentMethodQuery = PaymentMethod::query();
        
        if (!empty($keyword)) {
            $paymentMethodQuery->where('name', 'LIKE', '%' . $keyword . '%');
            $paymentMethodQuery->orWhere('percentage_charge', 'LIKE', '%' . $keyword . '%');
            $paymentMethodQuery->orWhere('amount_charge', 'LIKE', '%' . $keyword . '%');
            $paymentMethodQuery->orWhere('description', 'LIKE', '%' . $keyword . '%');
        }

        $payment_methods = $paymentMethodQuery->paginate($limit);
        return view('pages.payment_methods.browse', compact('payment_methods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.payment_methods.add');
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
            return redirect()->back()->with('failure', 'Failed to add New Payment Method. Validate your fields please');
        } else {
            $params = $request->all();
            $paymentMethod = PaymentMethod::create([
                'name' => $params['name'],
                'percentage_charge' => empty($params['percentage_charge']) ? 0 : $params['percentage_charge'],
                'amount_charge' => empty($params['amount_charge']) ? 0 : $params['description'],
                'is_active' => empty($params['is_active']) ? 
                                    false : ($params['is_active'] == 'on') ? 
                                        true : false,
                'description' => empty($params['description']) ? null : $params['description'],
            ]);
            return redirect()->back()->with('success', 'Successfully Added New Payment Method');   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $payment_method)
    {
        return view('pages.payment_methods.read', compact('payment_method'));
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
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        if ($paymentMethod === null) {
            return redirect()->back()->with('failure', 'Payment Method not found');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('failure', 'problem validating Payment Method. validate your fields');
        } else {
            $params = $request->all();
            $paymentMethod->name = $params['name'];
            $paymentMethod->percentage_charge = empty($params['percentage_charge']) ? 0 : $params['percentage_charge'];
            $paymentMethod->amount_charge = empty($params['amount_charge']) ? 0 : $params['amount_charge'];
            $paymentMethod->is_active = 
                empty($params['is_active']) ? 
                    false : ($params['is_active'] == 'on') ? 
                        true : false;
            $paymentMethod->description = empty($params['description']) ? null : $params['description'];
            $paymentMethod->save();
        }
        return redirect()->back()->with('success', 'Payment Method updated');
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
