<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required', 'required_with:password_confirm', 'same:password_confirm'],
            'password_confirm' => ['required'],
        ]);

        $user = User::where("email", $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Password Berhasil diubah',
            'data' => $user
        ], 200);
    }
}
