<?php

namespace App\Http\Controllers;

use App\SmsPin;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SmsPinController extends Controller
{
    public function index()
    {
        return SmsPin::all();
    }

    public function show(SmsPin $sms)
    {
        return $sms;
    }

    public function verifiedSmsCode(Request $request)
    {
        // $requestPinCode = SmsPin::where([
        //     ['phone_number', '=', $request['phone_number']],
        //     ['sms_pin', '=', $request['sms_pin']]
        // ])->latest('created_at')->first();

        $requestPinCode = SmsPin::where('phone_number', '=', $request['phone_number'])->latest('created_at')->first();

        if ($requestPinCode != null && $request['sms_pin'] == $requestPinCode->sms_pin) {
            return "true";
        } else {
            return "false";
        }
    }

    public function store(Request $request)
    {

        $randomPin = rand(100000, 999999);
        $request->request->add(['sms_pin' => $randomPin]);
        $data = $request->all();
        SmsPin::create($data);

        $msg = "STT MYANMAR, Your Authentication Code is :" .$randomPin;


        $client = new Client([
            'base_uri' => 'http://159.138.135.30',
        ]);

        $payload = '{"to":"' . $request['phone_number'] . '","message":"' . $msg . '","sender":"STT MYANMAR"}';

        $response = $client->post('/smsserver/sendsms-token', [
            'body' => $payload,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer lmE3S4WmuWrBPlVWtN9fX2YH',
            ]
        ]);
        $body = $response->getBody()->getContents();
        $dd = json_decode((string) $body);
        if ($dd) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 404);
        }



    }

    public function update(Request $request, SmsPin $sms)
    {
        $sms->update($request->all());

        return response()->json($sms, 200);
    }

    public function delete(SmsPin $sms)
    {
        $sms->delete();

        return response()->json(null, 204);
    }
}
