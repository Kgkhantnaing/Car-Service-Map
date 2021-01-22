<?php

namespace App\Http\Controllers;

use App\Noti;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotiController extends Controller
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Noti  $noti
     * @return \Illuminate\Http\Response
     */
    public function show(Noti $noti)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Noti  $noti
     * @return \Illuminate\Http\Response
     */
    public function edit(Noti $noti)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Noti  $noti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Noti $noti)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Noti  $noti
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noti $noti)
    {
        //
    }

    public function getLatestNoti()
    {
        $result = Noti::orderBy('id', 'desc')->take(20)->get();
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => "Success get notifications",
            'notifications' => $result,
        ], 200);
    }
}
