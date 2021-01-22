<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerHistory;
use Illuminate\Http\Request;

class CustomerHistoryController extends Controller
{
    public function search(Request $request)
    {
        // $cusHistoryList = CustomerHistory::where('created_at', '<>', NULL);
        // $secondQuery = null;
        // $thirdQuery = null;
        // $fourthQuery = null;
        // $finalQuery = null;
        // $firstQuery = clone $cusHistoryList;


        // if ($request['pincode'] != null) {
        //     $cusHistoryList = $firstQuery->where('pin_id', '=', $request['pincode']);
        //     $secondQuery = clone $cusHistoryList;
        //     $finalQuery = clone $cusHistoryList;
        // }


        // if ($request['transaction'] != null) {
        //     $dateArr = explode(" - ", $request['transaction']);

        //     $startDate = strtotime($dateArr[0]);
        //     $formattedStartDate = date('Y-m-d H:i:s', $startDate);

        //     $endDate = strtotime($dateArr[1]);
        //     $formattedEndDate = date('Y-m-d H:i:s', $endDate);

        //     if ($secondQuery != null) {
        //         $cusHistoryList =  $secondQuery->where([['created_at', '>=', $formattedStartDate], ['created_at', '<=', $formattedEndDate]]);
        //         $finalQuery = clone $cusHistoryList;
        //     } else {
        //         $finalQuery =  $firstQuery->where([['created_at', '>=', $formattedStartDate], ['created_at', '<=', $formattedEndDate]]);
        //     }
        // }

        // if ($request['customer'] != null) {

        //     if ($thirdQuery != null) {
        //         $cusHistoryList =  $thirdQuery->orwhere('customer_name', 'LIKE', "%{$request['pincode']}%")->orwhere('customer_phone_number', 'LIKE', "%{$request['pincode']}%");
        //         $finalQuery = clone $cusHistoryList;
        //     } else if ($secondQuery != null) {
        //         $cusHistoryList =  $secondQuery->where([['created_at', '>', $formattedStartDate], ['created_at', '<', $formattedEndDate]]);
        //         $finalQuery = clone $cusHistoryList;
        //     } else {
        //         // dd("here3");
        //         // $finalQuery =  $firstQuery->orwhere('customer_name', 'LIKE', "%{$request['customer']}%")->orwhere('customer_phone_number', 'LIKE', "%{$request['customer']}%");
        //         $searchTerm = $request['customer'];
        //         $finalQuery =  $firstQuery->where(function ($query) use ($searchTerm) {
        //             /** @var $query Illuminate\Database\Query\Builder  */
                    
        //             return $query->where('customer_name', 'LIKE', "%$searchTerm%")
        //                 ->orWhere('customer_phone_number', 'LIKE', "%$searchTerm%");
        //         });
        //         // dd($finalQuery);
        //     }
        // }

        // if ($request['pincode'] == null && $request['transaction'] == null && $request['customer'] == null) {
        //     $finalQuery = clone $cusHistoryList;
        // }

        // $cusHistoryList = clone $finalQuery;
        // $cusHistoryList = $cusHistoryList->orderBy('id','desc')->get();//->setPath('')

        // $cusHistoryList->appends(array(
        //     'transaction' => request('transaction'),
        //     'pincode' => request('pincode'),
        //     'customer' => request('customer')
        // ));
        $cusHistoryList = CustomerHistory::orderBy('id','desc')
                                        ->select('customer_histories.*','pin_codes.lucky_draw_amount as lucky_draw_amt','pin_codes.product_code as product_code')
                                        ->join('pin_codes','pin_codes.pin','=','customer_histories.pin_id')
                                        ->get();
        return view('pages.customer-history.customer-history-list', compact('cusHistoryList'));
    }

    public function viewCustomerHistory($id)
    {
        $cus = Customer::find($id);
        $cusHistoryList = CustomerHistory::orderBy('id','desc')
                                    ->select('customer_histories.*','pin_codes.lucky_draw_amount as lucky_draw_amt','pin_codes.product_code as product_code')
                                    ->join('pin_codes','pin_codes.pin','=','customer_histories.pin_id')
                                    ->where('customer_histories.customer_id',$cus->id)
                                    ->get();
        // dd($cusHistoryList);
        return view('pages.customer-history.index', compact('cus', 'cusHistoryList'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cusHistoryList = CustomerHistory::orderBy('id','desc')
                                        ->select('customer_histories.*','pin_codes.lucky_draw_amount as lucky_draw_amt','pin_codes.product_code as product_code')
                                        ->join('pin_codes','pin_codes.pin','=','customer_histories.pin_id')
                                        ->get();
        // dd($cusHistoryList);
        return view('pages.customer-history.customer-history-list', compact('cusHistoryList'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerHistory  $customerHistory
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerHistory $customerHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerHistory  $customerHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerHistory $customerHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerHistory  $customerHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerHistory $customerHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerHistory  $customerHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerHistory $customerHistory)
    {
        //
    }


    public function claimCustomer(Request $request)
    {
        if ($request['claim'] != null) {

            $decodedAsArray = json_decode($request['customerHistory'], true);
            $customerHistory = CustomerHistory::find($decodedAsArray['id']);

            $customerHistory->is_claim = 1;
            $customerHistory->save();
        } else {
            $decodedAsArray = json_decode($request['customerHistory'], true);
            $customerHistory = CustomerHistory::find($decodedAsArray['id']);

            $customerHistory->is_claim = 0;
            $customerHistory->save();
        }

        return redirect("customer/history");
    }
}
