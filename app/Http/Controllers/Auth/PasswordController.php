<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
//        dd($request->all());
        $this->validate($request,[
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
//        $validated = $request->validateWithBag('updatePassword', [
//            'current_password' => ['required', 'current_password'],
//            'password' => ['required', Password::defaults(), 'confirmed'],
//        ]);


        $request->user()->update([
            'password' => Hash::make($request['password']),
        ]);

        return back()->with('status', 'تم الحفظ بنجاح');
    }
}
