<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmergencyContact;
use App\City;
use App\Category;
use App\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EmergencyContactController extends Controller
{
    public function ApiGetData(Request $request)
    {
        $header = $request->header('AppToken');
        // dd($header);
        $user = Customer::where('token', '=', $header)->first();
        if ($user != null) {
            $result = EmergencyContact::select('emergency_contact.*','categories.name as category_name')->orderBy('emergency_contact.name','ASC')->join('categories','categories.id','=','emergency_contact.category_id')->get();
            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => "Success get Emergency Contact",
                'data' => $result,
            ], 200);
        } else {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "User not found",
            ], 401);
        }
    }

    public function ECWebIndex()
    {
        $ECList = EmergencyContact::select('emergency_contact.*','categories.name as category_name')->orderBy('emergency_contact.name','ASC')->join('categories','categories.id','=','emergency_contact.category_id')->get();
        // dd($ECList);
        return view('pages.emergency-contact.index',compact('ECList'));
    }

    public function ECWebCreate()
    {
        $city_list = City::all();
        $category_list = Category::all();
        return view('pages.emergency-contact.create',compact('city_list','category_list'));
    }

    public function ECWebStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $EC = new EmergencyContact();
            $EC->name = $request->name;
            $EC->image = "http://165.22.63.43/images/" . $name;
            $EC->address = $request->address;
            $EC->latitude = $request->latitude;
            $EC->longitude = $request->longitude;
            $EC->phone = $request->phone;
            $EC->city = $request->city;
            $EC->category_id = $request->category_id;
            $EC->save();

            return redirect('/emergency_contact');
        } else {

            $EC = new EmergencyContact();
            $EC->name = $request->name;
            $EC->image_url = "http://165.22.63.43/img/shop-hover.png";
            $EC->address = $request->address;
            $EC->latitude = $request->latitude;
            $EC->longitude = $request->longitude;
            $EC->phone = $request->phone;
            $EC->city = $request->city;
            $EC->category_id = $request->category_id;
            $EC->save();

            return redirect('/emergency_contact');
        }
    }

    public function ECWebEdit($id)
    {
       $EC = EmergencyContact::find($id);
       $city_list = City::all();
       $category_list = Category::all();
       return view('pages.emergency-contact.edit',compact('EC','city_list','category_list'));
    }

    public function ECWebUpdate(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        if ($request->hasFile('image')) {
            if(file_exists($request->old_image))
            {
                unlink($request->old_image);
            }

            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $EC = EmergencyContact::find($id);
            $EC->name = $request->name;
            $EC->image = "http://165.22.63.43/images/" . $name;
            $EC->address = $request->address;
            $EC->latitude = $request->latitude;
            $EC->longitude = $request->longitude;
            $EC->phone = $request->phone;
            $EC->city = $request->city;
            $EC->category_id = $request->category_id;
            $EC->update();

            return redirect('/emergency_contact');
        } else {

            $EC = EmergencyContact::find($id);
            $EC->name = $request->name;
            $EC->image = $request->old_image;
            $EC->address = $request->address;
            $EC->latitude = $request->latitude;
            $EC->longitude = $request->longitude;
            $EC->phone = $request->phone;
            $EC->city = $request->city;
            $EC->category_id = $request->category_id;
            $EC->update();

            return redirect('/emergency_contact');
        }
    }

    public function ECWebDetail($id)
    {
        $EC = EmergencyContact::select('emergency_contact.*','categories.name as category_name')->where('emergency_contact.id',$id)->join('categories','categories.id','=','emergency_contact.category_id')->first();
        return view('pages.emergency-contact.detail',compact('EC'));
    }

    public function ECWebDelete($id)
    {
        $ec = EmergencyContact::find($id);

        $ec->delete();
        return redirect()->back();
    }
}
