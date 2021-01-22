<?php

namespace App\Http\Controllers;

use App\Exports\PinCodeExport;
use App\PinCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Integer;
use Rap2hpoutre\FastExcel\FastExcel;
use DB;

class PinCodeController extends Controller
{
    public function index()
    {
        return PinCode::all();
    }
    public function indexUi()
    {
        $pins = PinCode::all();
        $pins = DB::table('pin_codes')->get();
        $currentFilter = 2;
        return view('pages.pincode.index', compact('pins', 'currentFilter'));
    }

    public function show(PinCode $pin)
    {
        return $pin;
    }

    public function verifiedPinCode(Request $request)
    {
        $requestPinCode = PinCode::where('pin', '=', $request['pin_code'])->get()->first();
        if ($requestPinCode != null) {

            if ($requestPinCode->is_used) {
                return response()->json("true", 200);;
            } else {
                return response()->json("false", 200);;
            }
        } else {
            return response()->json(null, 404);
        }
    }

    public function store(Request $request)
    {
        $digits = 13;
        for ($i = 0; $i < $request['pin']; $i++) {
            $pin = new PinCode();
            $pin->pin = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $pin->lucky_draw_amount = $request['lucky_draw_amount'];
            $pin->is_used = 0;
            $pin->product_code = $request['product_code'];
            $pin->save();
        }
        // factory(PinCode::class, (int) $request['pin'])->create();
        return redirect('/pincodes');
    }
    public function create()
    {
        return view('pages.pincode.create');
    }

    public function update(Request $request, PinCode $pin)
    {
        $pin->update($request->all());

        return response()->json($pin, 200);
    }

    public function delete(PinCode $pin)
    {
        $pin->delete();

        return response()->json(null, 204);
    }
    public function generate(Request $request)
    {
        // $this->validate($request, [
        //     'pincodes_csv' => 'required|in:csv',
        // ]);

        if ($request->hasFile('pincodes_csv')) {
            $csvFile = $request->file('pincodes_csv');
            $name = time() . '.' . $csvFile->getClientOriginalExtension();
            $destinationPath = public_path('/file');
            $csvFile->move($destinationPath, $name);
            if (($handle = fopen(public_path() . '/file/' . $name, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $csv_data = new PinCode();
                    $csv_data->pin = $data[1];
                    $csv_data->is_used = 0;
                    $csv_data->save();
                }
                fclose($handle);
            }

            return route("/pincodes");
        } else {
            return response()->json(false, 404);
        }
    }

    function csvToArray($filename = '', $delimiter = ';')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = [];
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    public function importCsv()
    {
        $file = public_path('file/test.csv');

        $customerArr = $this->csvToArray($file);

        dd($customerArr);
        for ($i = 0; $i < count($customerArr); $i++) { }

        return 'Jobi done or what ever';
    }

    public function export()
    {

        $pincodes = PinCode::all();
        return (new FastExcel($pincodes))->download('Pincodes.xlsx');
    }

    public function download()
    {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',   'Content-type'        => 'text/csv',   'Content-Disposition' => 'attachment; filename=galleries.csv',   'Expires'             => '0',   'Pragma'              => 'public'
        ];

        $list = PinCode::all()->toArray();

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

        $callback = function () use ($list) {
            $FH = fopen('php://output', 'w');
            foreach ($list as $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function filter()
    {
        $currentFilter = 2;
        $pins = null;
        if (request('isUsed') == 0 || request('isUsed') == 1) {
            $pins = PinCode::where('is_used', '=', request('isUsed'))->orderBy('pin', 'desc')->get();
            $currentFilter = request('isUsed');
        } else {
            $pins = PinCode::orderBy('pin', 'desc')->get();
            $currentFilter = request('isUsed');
        }

        // $pins->appends(array(
        //     'isUsed' => request('isUsed')
        // ));


        return view('pages.pincode.index', compact('pins', 'currentFilter'));
    }
}
