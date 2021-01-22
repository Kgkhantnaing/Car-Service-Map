<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Shop;
use App\City;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
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
            $result = Category::all();
            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => "Success get categories",
                'categories' => $result,
            ], 200);
        } else {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "User not found",
            ], 401);
        }
    }

    public function ShopWithCategory(Request $request)
    {
        $header = $request->header('AppToken');
        $user = Customer::where('token', '=', $header)->first();
        if ($user != null) {
            $categoryList = Category::with('shops')->get();
            return response()->json([
                'code' => Response::HTTP_OK,
                'message' => "Success get shop_with_category",
                'shop_with_category' => $categoryList,
            ], 200);
        } else {
            return response()->json([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => "User not found",
            ], 401);
        }
    }

    public function uiGetALlCategories()
    {
        $categoryList = Category::orderBy('id', 'ASC')->get();
        // $pageNumber = Category::orderBy('id', 'DESC')->paginate(10)->currentPage();
        // dd($categoryList->key);
        return view('pages.category.index', compact('categoryList'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect('/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    public function editCategory($id)
    {
        $cat = Category::find($id);

        return view('pages.category.edit', compact('cat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }
    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->save();

        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function deleteCategory($id)
    {
        $shop = Shop::where('category_id', '=', $id)->delete();
        $category = Category::find($id);
        $category->delete();
        return redirect('/categories');
    }

    public function cityWebIndex()
    {
        $cityList = City::orderBy('city_name','ASC')->get();
        return view('pages.city.index',compact('cityList'));
    }

    public function cityWebCreate()
    {
       return view('pages.city.create');
    }

    public function cityWebStore(Request $request)
    {
        City::create($request->all());
        return redirect('/city-categories');
    }

    public function cityWebEdit($id)
    {
       $city = City::find($id);
       return view('pages.city.edit',compact('city'));
    }

    public function cityWebUpdate(Request $request,$id)
    {
        $city = City::find($id);
        DB::table('shops')->where('city',$city->city_name)->update(['city'=> $request->city_name]);
        $city->update($request->all());
        return redirect('/city-categories');
    }

    public function cityWebDelete($id)
    {
        $city = City::find($id);        
        $exist = DB::table('shops')->where('city',$city->city_name)->count() == 0 ? true : false;
        
        if($exist)
        {            
            $city->delete();
            return redirect()->back();
        }else{            
            return redirect()->back()->with('msg',"Shops are exist! You Can't Delete This Record! If you want to delete, you must delete relevant shops first!");
        }
    }
}
