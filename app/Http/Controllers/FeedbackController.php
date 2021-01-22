<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Feedback;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Carbon\Carbon;
class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbackList = DB::table('feedback')->join('customers','customers.id','feedback.customer_id')->select('name','feedback.*')->get();
        return view('pages.feedback.index', compact('feedbackList'));
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
        $header = $request->header('AppToken');
        $user = Customer::where('token', '=', $header)->first();
        if ($user != null) {
            
            $feedback = new Feedback();
            $feedback->customer_id = $request->input('customer_id');
            $feedback->customer_phone_number = $request->input('customer_phone_number');
            $feedback->feedback_body = $request->input('feedback_body');
            $feedback->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $feedback->save();
    
            return response()->json(true, 200);
        } else {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "User not found",
            ], 401);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        $feedback_id = $feedback->id;
        $feedbackDetail = DB::table('feedback')->join('customers','customers.id','feedback.customer_id')->select('name','feedback.*')->where('feedback.id','=',$feedback_id)->first();
        return view('pages.feedback.show', compact('feedbackDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return redirect('/feedbacks');
    }
}
