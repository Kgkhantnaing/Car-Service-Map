<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Shop;
use App\User;
use App\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Rap2hpoutre\FastExcel\FastExcel;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $header = $request->header('AppToken');
        $user = Customer::where('token', '=', $header)->first();
        if ($user != null) {

            $result = Shop::orderBy('name', 'ASC')->get();
            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => "Success get shops",
                'shops' => $result,
            ], 200);
        } else {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "User not found",
            ], 401);
        }
    }
    public function search(Request $request)
    {
        if ($request->has('keyword') && $request->keyword != '') {
            $shopList = Shop::whereRaw('match(name, address, description, phone_no, city, remark) against (?)', $request->keyword)->paginate(10);
        } else if ($request->keyword == '') {
            $shopList = Shop::orderBy('name', 'ASC')->paginate(12);
        }
        return view('pages.shop.index', compact('shopList'));
    }

    public function uiGetALlShops()
    {
        $shopList = Shop::orderBy('name', 'ASC')->paginate(9);
        return view('pages.index', compact('shopList'));
    }

    public function uiTableGetALlShops()
    {
        $shopList = Shop::orderBy('name', 'ASC')->get();
        return view('pages.shop.index', compact('shopList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryList = Category::orderBy('name', 'ASC')->get();
        $cityList = City::orderBy('city_name', 'ASC')->get();
        return view('pages.shop.create', compact('categoryList','cityList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $this->validate($request, [
        //     'shop_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);


        $validator = Validator::make($request->all(), [
            'shop_img' => 'image|mimes:jpeg,png,jpg|max:2048',
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/']
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->first());
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        if ($request->hasFile('shop_img')) {
            $image = $request->file('shop_img');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $shop = new Shop();
            $shop->name = $request->input('name');
            $shop->image_url = "http://165.22.63.43/images/" . $name;
            $shop->address = $request->input('address');
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->description = $request->input('description') != null ? $request->input('description') : "";
            $shop->phone_no = $request->input('phone');
            $shop->city = $request->input('city');
            $shop->remark = $request->input('remark') != null ? $request->input('remark') : "";
            $shop->category_id = $request->input('category');
            $shop->save();

            return redirect('/shops');
        } else {
            $shop = new Shop();
            $shop->name = $request->input('name');
            $shop->image_url = "http://165.22.63.43/img/shop-hover.png";
            $shop->address = $request->input('address');
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->description = $request->input('description') != null ? $request->input('description') : "";
            $shop->phone_no = $request->input('phone');
            $shop->city = $request->input('city');
            $shop->remark = $request->input('remark') != null ? $request->input('remark') : "";
            $shop->category_id = $request->input('category');
            $shop->save();

            return redirect('/shops');
        }


        // return redirect()->to($this->getRedirectUrl())
        // ->withInput($request->input())
        // ->withErrors($errors, $this->errorBag());


    }
    public function storeApi(Request $request)
    {
        $header = $request->header('AppToken');
        $user = Customer::where('token', '=', $header)->first();
        if ($user != null) {
            $shop = new Shop();
            $shop->name = $request->input('name');
            $shop->image_url = $request->input('image_url') != null ? $request->input('image_url') : "http://165.22.63.43/img/shop-hover.png";
            $shop->address = $request->input('address');
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->description = $request->input('description');
            $shop->phone_no = $request->input('phone_no');
            $shop->city = $request->input('city');
            $shop->remark = $request->input('remark') != null ? $request->input('remark') : "";
            $shop->category_id = $request->input('category_id');
            $shop->save();

            return response()->json("true", 200);
        } else {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "User not found",
            ], 401);
        }
    }

    public function uploadShopPhoto(Request $request)
    {
        $header = $request->header('AppToken');
        $user = Customer::where('token', '=', $header)->first();
        if ($user != null) {
            $this->validate($request, [
                'shop_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('shop_img')) {
                $image = $request->file('shop_img');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images');
                $image->move($destinationPath, $name);


                return "http://165.22.63.43/images/" . $name;
            } else {
                return response()->json("false", 404);
            }
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
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop, $id)
    {
        $shopDetail = Shop::find($id);
        $category = Category::find($shopDetail->category_id);
        // dd($shopDetail);
        return view('pages.shop.detail', compact('shopDetail', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }
    public function editShop($id)
    {
        $shop = Shop::find($id);
        $selectedCategory = Category::find($shop->category_id);
        $categories = Category::orderBy('name', 'ASC')->get();
        $cityList = City::orderBy('city_name','ASC')->get();

        return view('pages.shop.edit', compact('shop', 'selectedCategory', 'categories','cityList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $header = $request->header('AppToken');
        $user = Customer::where('token', '=', $header)->first();
        if ($user != null) {
            $shop = Shop::find($id);
            $shop->name = $request->input('name');
            $shop->image_url = $request->input('image_url');
            $shop->address = $request->input('address');
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->description = $request->input('description');
            $shop->phone_no = $request->input('phone_no');
            $shop->city = $request->input('city');
            $shop->remark = $request->input('remark') != null ? $request->input('remark') : "";
            $shop->category_id = $request->input('category_id');
            $shop->save();

            return response()->json($shop, 200);
        } else {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "User not found",
            ], 401);
        }
    }
    public function updateShop(Request $request, $id)
    {


        if ($request->hasFile('shop_img')) {
            $this->validate($request, [
                'shop_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('shop_img');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $shop = Shop::find($id);
            $shop->name = $request->input('name');
            $shop->image_url = "http://165.22.63.43/images/" . $name;
            $shop->address = $request->input('address');
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->description = $request->input('description') != null ? $request->input('description') : "";
            $shop->phone_no = $request->input('phone');
            $shop->city = $request->input('city');
            $shop->remark = $request->input('remark') != null ? $request->input('remark') : "";
            $shop->category_id = $request->input('category');
            $shop->save();

            return redirect('/shops');
        } else {
            $shop = Shop::find($id);
            $shop->name = $request->input('name');
            $shop->image_url = $request->input('shop_img_hidden');
            $shop->address = $request->input('address');
            $shop->latitude = $request->input('latitude');
            $shop->longitude = $request->input('longitude');
            $shop->description = $request->input('description') != null ? $request->input('description') : "";
            $shop->phone_no = $request->input('phone');
            $shop->city = $request->input('city');
            $shop->remark = $request->input('remark') != null ? $request->input('remark') : "";
            $shop->category_id = $request->input('category');
            $shop->save();
            return redirect('/shops');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
    }

    public function deleteShop($id)
    {
        $shop = Shop::find($id);
        $shop->delete();
        return redirect('/shops');
    }

    public function export()
    {
        $shopList = Shop::select(
                        'shops.name as Name',
                        'shops.image_url as Image',
                        'shops.address as Address',
                        'shops.latitude as Latitude',
                        'shops.longitude as Longitude',
                        'shops.description as Description',
                        'shops.phone_no as Phone Number',
                        'shops.city as City',
                        'shops.remark as Remark',
                        'categories.name as Category Name'
                        )
                        ->join('categories','categories.id','=','category_id')
                        ->get();
        return (new FastExcel($shopList))->download('Shops.xlsx');
    }
}
