<?php

namespace App\Http\Controllers;
use App\Customer;
use App\CustomerHistory;
use App\Feedback;
use App\Noti;
use App\PinCode;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Customer::all();
    }
    public function indexUi()
    {
        session()->put('currentTime', Carbon::now());
        $cusList = Customer::orderBy('created_at', 'desc')
                            ->select('customers.*','pin_codes.lucky_draw_amount as lucky_amount','pin_codes.product_code as p_code')
                            ->join('pin_codes','customers.pin_code','=','pin_codes.pin')
                            ->get();
        // dd($cusList);
        return view('pages.customer.index', compact('cusList'));
    }

    public function show(Customer $customer)
    {
        return $customer;
    }

    public function login(Request $request)
    {
        $loginUser = Customer::where([
            ['phone_number', '=', $request['phone_number']]
        ])->get()->first();

        if ($loginUser != null) {
            $hashedPassword  = $loginUser->password;
            if (Hash::check($request['password'], $hashedPassword)) {
                // The passwords match...
                return response()->json($loginUser, 200);
            } else {

                return response()->json("Something went wrong", 404);
            }
        } else {
            return response()->json("No user registered", 404);
        }
    }

    public function store(Request $request)
    {
        $customer = Customer::where([
            ['phone_number', '=', $request['phone_number']]
        ])->get()->first();
        if ($customer == null) {
            $pinId = PinCode::where('pin', '=', $request['pin_code'])->get()->first();
            if ($pinId != null) {
                if ($pinId->is_used == 0) {
                    $request->request->add(['token' => Str::random(30),]);
                    $request['password'] = bcrypt($request['password']);
                    $data = $request->all();
                    $customer = Customer::create($data);
                    $cusHistory = new CustomerHistory();
                    $cusHistory->pin_id = $pinId->pin;
                    $cusHistory->pin_flag = 1;
                    $cusHistory->customer_id = $customer->id;
                    $cusHistory->customer_phone_number = $customer->phone_number;
                    $cusHistory->customer_name = $customer->name;
                    $cusHistory->is_claim = 0;
                    $cusHistory->save();
                    $pinId->is_used = 1;
                    $pinId->save();

                    $emailData = '<html> <p>Dear All,<br /> There is a new lucky draw please check your system and Lucky draw credentials are as follows.<br /><br />Customer Name &ndash; ' . $cusHistory->customer_name . '<br /><br />Phone Number &ndash; ' . $cusHistory->customer_phone_number . '<br /><br />Status &ndash; New<br /><br />Lucky Draw Amount &ndash; ' . $pinId->lucky_draw_amount . '<br /><br />Product Code &ndash; ' . $pinId->product_code . '</p> </html>';

                    Mail::send([], [], function ($message) use ($emailData, $cusHistory) {
                        $message->to('shwetaungtetmm7@gmail.com', 'Admin')->subject('New Lucky Draw Notification – ' . $cusHistory->customer_phone_number)->setBody($emailData, 'text/html');
                        $message->from('shwetaungtetmm7@gmail.com', 'Admin');
                    });
                    return response()->json($customer, 201);
                } else {
                    return response()->json("Please try other pin code", 200);
                }
            } else {
                return "pin code not found";
            }
        } else {
            return "Phone Number Already exist";
        }
    }

    public function storeUi(Request $request)
    {

        $request->validate([
            'phone_number' => 'required|unique:customers',
        ]);

        $customer = Customer::where([
            ['phone_number', '=', $request['phone_number']]
        ])->get()->first();
        $pinId = PinCode::where('pin', '=', $request['pin_code'])->get()->first();
        $this->validate($request, [
            'customer_photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($customer == null) {
            if ($pinId != null) {
                if ($pinId->is_used == 0) {
                    // if ($request->hasFile('customer_photo')) {
                    //     $image = $request->file('customer_photo');
                    //     $name = time() . '.' . $image->getClientOriginalExtension();
                    //     $destinationPath = public_path('/images/user_photos');
                    //     $image->move($destinationPath, $name);
                    //     $request->request->add(['token' => Str::random(30),]);
                    //     $request->request->add(['user_photo' => "http://165.22.63.43/images/user_photos/" . $name,]);
                    //     $request['password'] = bcrypt($request['password']);
                    //     if ($request['pin_code'] == '0') {
                    //         $request['type'] = 1;
                    //     } else {
                    //         $request['type'] = 0;
                    //     }
                    //     $data = $request->all();
                    //     $customer = Customer::create($data);
                    //     if ($request['pin_code'] != '0') {
                    //         $pinId->is_used = 1;
                    //     }
                    //     $pinId->save();
                    //     return redirect('/customers');
                    // }

                    if ($request['pin_code'] != '0') {
                        if ($request->hasFile('customer_photo')) {
                            $image = $request->file('customer_photo');
                            $name = time() . '.' . $image->getClientOriginalExtension();
                            $destinationPath = public_path('/images/user_photos');
                            $image->move($destinationPath, $name);
                            $request->request->add(['token' => Str::random(30),]);
                            $request->request->add(['user_photo' => "http://165.22.63.43/images/user_photos/" . $name,]);
                            $request['password'] = bcrypt($request['password']);
                            $request['type'] = 0;
                            $data = $request->all();
                            $customer = Customer::create($data);
                            $pinId->is_used = 1;
                            $pinId->save();
                            return redirect('/customers');
                        } else {
                            return Redirect()->back()->withInput($request->all())->withErrors(['Please choose your profile picture']);
                        }
                    } else {
                        if ($request->hasFile('customer_photo')) {
                            $image = $request->file('customer_photo');
                            $name = time() . '.' . $image->getClientOriginalExtension();
                            $destinationPath = public_path('/images/user_photos');
                            $image->move($destinationPath, $name);
                            $request->request->add(['token' => Str::random(30),]);
                            $request->request->add(['user_photo' => "http://165.22.63.43/images/user_photos/" . $name,]);
                            $request['password'] = bcrypt($request['password']);
                            $request['type'] = 1;
                            $data = $request->all();
                            $customer = Customer::create($data);
                            return redirect('/customers');
                        } else {
                            $request->request->add(['token' => Str::random(30),]);
                            $request->request->add(['user_photo' => "http://165.22.63.43/images/admin_user.png"]);
                            $request['password'] = bcrypt($request['password']);
                            $request['type'] = 1;
                            $data = $request->all();
                            $customer = Customer::create($data);
                            return redirect('/customers');
                        }
                    }
                } else {
                    // return response()->json("Please try other pin code", 200);
                    return Redirect()->back()->withInput($request->all())->withErrors(['Please try other pin code']);
                }
            } else {
                return Redirect()->back()->withInput($request->all())->withErrors(['Pincode not found']);
            }
        } else {
            return Redirect()->back()->withInput($request->all())->withErrors(['This user already exist']);
        }
    }

    public function uploadCustomerPhoto(Request $request)
    {
        $this->validate($request, [
            'customer_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('customer_photo')) {
            $image = $request->file('customer_photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/user_photos');
            $image->move($destinationPath, $name);


            return "http://165.22.63.43/images/user_photos/" . $name;
        } else {
            return response()->json(false, 404);
        }
    }

    // public function update(Request $request, Customer $customer)
    // {
    //     $customer->update($request->all());

    //     return response()->json($customer, 200);
    // }

    public function update(Request $request)
    {
        $header = $request->header('usertoken');


        $customer = Customer::where('token', '=', $header)->get()->first();
        if ($customer != null) {

            if ($request->input('password') != '') {
                $customer->name = $request->input('name');
                $customer->user_photo = $request->input('user_photo');
                $customer->phone_number = $request->input('phone_number');
                $customer->password = bcrypt($request['password']);
                $customer->save();
                return response()->json($customer, 201);
            } else {
                $customer->name = $request->input('name');
                $customer->user_photo = $request->input('user_photo');
                $customer->phone_number = $request->input('phone_number');
                $customer->save();
                return response()->json($customer, 201);
            }

            // if ($request->input('user_photo') != '') {
            //     $customer->name = $request->input('name');
            //     $customer->user_photo = $request->input('user_photo');
            //     $customer->phone_number = $request->input('phone_number');
            //     // $customer->password = bcrypt($request['password']);
            //     $customer->save();

            //     return response()->json($customer, 201);
            // } else if ($request->input('password') != '') {
            //     $customer->name = $request->input('name');
            //     $customer->phone_number = $request->input('phone_number');
            //     $customer->password = bcrypt($request['password']);
            //     $customer->save();
            //     return response()->json($customer, 201);
            // } else {
            //     $customer->name = $request->input('name');
            //     $customer->phone_number = $request->input('phone_number');
            //     $customer->save();
            //     return response()->json($customer, 201);
            // }
        } else {
            return response()->json("request not found", 404);
        }
    }


    public function updateCustomer(Request $request, $id)
    {
        if ($request->hasFile('customer_photo')) {
            $this->validate($request, [
                'customer_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('customer_photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/user_photos');
            $image->move($destinationPath, $name);

            $customer = Customer::find($id);
            $customer->name = $request->input('name');
            $customer->user_photo = "http://165.22.63.43/images/user_photos/" . $name;
            $customer->phone_number = $request->input('phone_number');
            if ($request['password'] != null) {
                $customer->password = bcrypt($request['password']);
            }
            $customer->save();
            return redirect('/customers');
        } else {
            $customer = Customer::find($id);
            $customer->name = $request->input('name');
            $customer->phone_number = $request->input('phone_number');
            if ($request['password'] != null) {
                $customer->password = bcrypt($request['password']);
            }
            $customer->save();
            return redirect('/customers');
        }
    }

    public function resetPassword(Request $request)
    {

        $customer = Customer::where('phone_number', '=', $request->input('phone_number'))->get()->first();
        if ($customer != null) {

            if ($request->input('password') != '') {
                $customer->password = bcrypt($request['password']);
                $customer->save();

                return response()->json($customer, 201);
            }
        } else {
            return response()->json("request not found", 404);
        }
    }

    public function create()
    {
        return view('pages.customer.create');
    }
    public function edit($id)
    {
        $cus = Customer::find($id);
        return view('pages.customer.edit', compact('cus'));
    }

    public function delete(Customer $customer)
    {
        $feedback = Feedback::where('customer_id', '=', $customer->id)->delete();
        $customer->delete();

        return response()->json(null, 204);
    }

    public function deleteUi($id)
    {
        $feedback = Feedback::where('customer_id', '=', $id)->delete();
        $cus = Customer::find($id);
        $cus->delete();
        return redirect('/customers');
    }

    public function checkCustomerAlreadyExit(Request $request)
    {
        $user = Customer::where([
            ['phone_number', '=', $request['phone_number']]
        ])->get()->first();

        if ($user != null) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function notiform()
    {
        return view('pages.pushnoti');
    }

    public function pushnoti(Request $request)
    {

        $error = $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $client = new Client([
            'base_uri' => 'https://fcm.googleapis.com',
        ]);

        $notiData = '{ "notification": {"title": "' . $request['title'] . '","text": "' . $request['description'] . '","click_action": "FLUTTER_NOTIFICATION_CLICK"},"data": {"keyname": "default"},"condition": "!(\'anytopicyoudontwanttouse\' in topics)"} ';
        $notiDataWithTopic = '{ "notification": { "title": "' . $request['title'] . '", "text": "' . $request['description'] . '", "click_action": "FLUTTER_NOTIFICATION_CLICK" }, "data": { "keyname": "default" }, "to":"/topics/stt_car_service" }';

        $response = $client->post('/fcm/send', [
            'body' => $notiDataWithTopic,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'key=AAAA1vjx7Tk:APA91bFH7SVBWRd3CB2NOEhill2EDZbqTo_nnky82xeR7F1R0Bq5et3fW2nvOxUkAT3F5JYHzY8swGgLi7QFjr7vOTIDqTw24ffhlgBLD1HRZOu_aKEiP_67pdbmh7iqb1pe0mSBfkDa'
            ]
        ]);
        $body = $response->getBody()->getContents();
        $dd = json_decode((string) $body);
        if ($dd) {
            $requestData = $request->all();
            Noti::create($requestData);
            return redirect('/home');
        } else {
            return Redirect::back()->withErrors($error)->withInput($request->all());
        }
    }

    public function export()
    {
        $cusList = Customer::all();
        return (new FastExcel($cusList))->download('Customers.xlsx');
    }


    public function renewLuckydraw(Request $request)
    {
        // phone_number/ old_pincode/ new_pincode

        $oldPin = PinCode::findUsedPinCode($request['old_pincode'])->first();

        if ($oldPin != null) {
            $customer = Customer::getCustomerByPhoneAndOldPin($request['phone_number'], $request['old_pincode'])->first();
            if ($customer != null) {
                $newPin = PinCode::findNewPinCode($request['new_pincode'])->first();
                if ($newPin != null) {

                    // $msg = "STT Myanmar, Thanks";
                    // $client = new Client([
                    //     'base_uri' => 'http://159.138.135.30',
                    // ]);

                    // $payload = '{"to":"' . $request['phone_number'] . '","message":"' . $msg . '","sender":"STT MYANMAR"}';

                    // $response = $client->post('/smsserver/sendsms-token', [
                    //     'body' => $payload,
                    //     'headers' => [
                    //         'Content-Type' => 'application/json',
                    //         'Authorization' => 'Bearer lmE3S4WmuWrBPlVWtN9fX2YH',
                    //     ]
                    // ]);
                    // $body = $response->getBody()->getContents();
                    // $dd = json_decode((string) $body);
                    // if ($dd) {
                        
                    // } else {
                    //     return response()->json(false, 200);
                    // }
                    $cusInfo = Customer::find($customer->id);
                    $cusHistory = new CustomerHistory();
                    $cusHistory->pin_id = $newPin->pin;
                    $cusHistory->customer_id = $customer->id;
                    $cusHistory->customer_name = $cusInfo->name;
                    $cusHistory->customer_phone_number = $cusInfo->phone_number;
                    $cusHistory->is_claim = 0;
                    $cusHistory->pin_flag = 2;
                    $cusHistory->save();

                    $updatePincode = PinCode::find($newPin->id);
                    $updatePincode->is_used = 1;
                    $updatePincode->save();

                    $emailData = '<html> <p>Dear All,<br /> There is a new lucky draw please check your system and Lucky draw credentials are as follows.<br /><br />Customer Name &ndash; ' . $cusHistory->customer_name . '<br /><br />Phone Number &ndash; ' . $cusHistory->customer_phone_number . '<br /><br />Status &ndash; Next Purchase<br /><br />Lucky Draw Amount &ndash; ' . $updatePincode->lucky_draw_amount . '<br /><br />Product Code &ndash; ' . $updatePincode->product_code . '</p> </html>';

                    Mail::send([], [], function ($message) use ($emailData, $cusHistory) {
                        $message->to('shwetaungtetmm7@gmail.com', 'Admin')->subject('New Lucky Draw Notification – ' . $cusHistory->customer_phone_number)->setBody($emailData, 'text/html');
                        $message->from('shwetaungtetmm7@gmail.com', 'Admin');
                    });

                    return response()->json(true, 200);
                } else {
                    return response()->json("Invalid new pincode ", 200);
                }
            } else {
                return response()->json("Invalid phone number or old pincode ", 200);
            }
        } else {
            return response()->json("Invalid old pincode ", 200);
        }
    }



    public function cusNameAutocomplete(Request $request)
    {
        $data = Customer::select("name")
            ->orWhere("name", "LIKE", "%{$request->input('query')}%")
            ->get();

        return response()->json($data);
    }



    public function basic_email()
    {
        $data = array('name' => "Aung Myo Oo");

        // $emailData = '<p><span data-contrast="auto">Subject &ndash;</span><span data-contrast="auto">&nbsp;New Lucky Draw Notification&nbsp;</span><span data-contrast="auto">&ndash; placeholdertext</span></p> <p><span data-contrast="auto">Body -&nbsp;</span><span data-contrast="auto">Dear</span><span data-contrast="auto">&nbsp;All,&nbsp;</span><span data-contrast="auto">There</span><span data-contrast="auto">&nbsp;is a new lucky draw&nbsp;</span><span data-contrast="auto">please check your system and</span><span data-contrast="auto">&nbsp;Lucky draw</span><span data-contrast="auto">&nbsp;</span><span data-contrast="auto">c</span><span data-contrast="auto">redentials</span><span data-contrast="auto"> are as follows.</span><span data-ccp-props="{&quot;201341983&quot;:0,&quot;335559739&quot;:160,&quot;335559740&quot;:259}">&nbsp;</span></p> <p><span data-contrast="auto">Customer Name &ndash;&nbsp;</span><span data-ccp-props="{&quot;201341983&quot;:0,&quot;335559739&quot;:160,&quot;335559740&quot;:259}">&nbsp;placeholdertext</span></p> <p><span data-contrast="auto">Phone Number &ndash;</span><span data-ccp-props="{&quot;201341983&quot;:0,&quot;335559739&quot;:160,&quot;335559740&quot;:259}">&nbsp;placeholdertext</span></p> <p><span data-contrast="auto">Status &ndash; New/Next Purchase</span><span data-ccp-props="{&quot;201341983&quot;:0,&quot;335559739&quot;:160,&quot;335559740&quot;:259}">&nbsp;</span></p> <p><span data-contrast="auto">Lucky Draw Amount &ndash;&nbsp;</span><span data-ccp-props="{&quot;201341983&quot;:0,&quot;335559739&quot;:160,&quot;335559740&quot;:259}">&nbsp;placeholdertext</span></p> <p><span data-contrast="auto">Product Code -&nbsp;</span><span data-ccp-props="{&quot;201341983&quot;:0,&quot;335559739&quot;:160,&quot;335559740&quot;:259}">&nbsp;placeholdertext</span></p> <p><span data-ccp-props="{&quot;201341983&quot;:0,&quot;335559739&quot;:160,&quot;335559740&quot;:259}">&nbsp;</span></p>';

        // Mail::send([], [], function ($message) {
        //     $message->to('faroakkhan@gmail.com', 'Customer Name')->subject('Laravel Basic Testing Mail')->setBody('<h1>Hi, welcome user!</h1><br> hello world', 'text/html');
        //     $message->from('dev.aungmyooo2015@gmail.com', 'Aung Myo Oo');
        // });
        $cusHistory = CustomerHistory::find(1);
        $updatePincode = PinCode::find(145870);
        $emailData = '<html> <p>Dear All,<br /> There is a new lucky draw please check your system and Lucky draw credentials are as follows.<br /><br />Customer Name &ndash; ' . $cusHistory->customer_name . '<br /><br />Phone Number &ndash; ' . $cusHistory->customer_phone_number . '<br /><br />Status &ndash; Next Purchase<br /><br />Lucky Draw Amount &ndash; ' . $updatePincode->lucky_draw_amount . '<br /><br />Product Code &ndash; ' . $updatePincode->product_code . '</p> </html>';

        $mailSender = Mail::send([], [], function ($message) use ($emailData) {
            $message->to('dev.aungmyooo2015@gmail.com', 'Admin')->subject('New Lucky Draw Notification – 098776543')->setBody($emailData, 'text/html');
            $message->from('dev.aungmyooo2015@gmail.com', 'Admin');
        });
        echo "Basic Email Sent. Check your inbox. " . $mailSender;
    }
    public function html_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send([], [], function ($message) {
            $message->to('faroakkhan@gmail.com', 'Customer Name')->subject('Laravel HTML Testing Mail');
            $message->from('dev.aungmyooo2015@gmail.com', 'Aung Myo Oo');
        });
        echo "HTML Email Sent. Check your inbox.";
    }
    public function attachment_email()
    {
        $data = array('name' => "Virat Gandhi");
        Mail::send([], [], function ($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject('Laravel Testing Mail with Attachment');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('xyz@gmail.com', 'Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}
