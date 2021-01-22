<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexUi()
    {
        $adminList = User::paginate(15);
        return view('pages.admin.index', compact('adminList'));
    }

    public function create()
    {
        return view('pages.admin.create');
    }

    public function storeUi(Request $request)
    {
        $request['password'] = bcrypt($request['password']);
        $data = $request->all();
        User::create($data);

        return redirect('/admins');
    }

    public function forgotPasswordUi()
    {
        $message = '';
        return view('pages.admin.forgotpwd', compact('message'));
    }

    public function resetPasswordUi(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->get()->first();

        if ($user != null) {
            $user->password = bcrypt($request['password']);
            $user->save();
            return redirect('/login');
        }else{
            $message = 'User not found';
            return view('pages.admin.forgotpwd', compact('message'));
        }
    }

    public function deleteUi($id)
    {
        $admin = User::find($id);
        $admin->delete();
        return redirect('/admins');
    }

    public function editUi($id)
    {
        $user = User::find($id);
        return view('pages.admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if($request['password'] != null){
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();
            return redirect('/admins');
        } else {
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->save();
            return redirect('/admins');
        }


    }
}
