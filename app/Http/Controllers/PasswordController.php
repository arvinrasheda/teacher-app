<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function index()
    {
        $user = session('user');
        return view('password', compact('user'));
    }

    public function change(Request $request)
    {
        $input = $request->except('_token');

        $model = User::find($input['id']);
        if ($model->pass == $input['old_password']) {
            $model->pass = $input['new_password'];
            $model->save();
            return redirect()->route('password.index')->with('successmessage', 'password berhasil diubah');
        }
        return redirect()->route('password.index')->with('errormessage', 'password lama tidak sesuai');
    }
}
