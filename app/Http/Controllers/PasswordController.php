<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::min(8), 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('akunpassword.edit')
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
            ->route('akunpassword.edit')
            ->with('success', 'Password berhasil diubah.');
    }
}