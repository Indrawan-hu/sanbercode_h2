<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\OtpCode;
use App\User;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);

        $rand = rand(100000, 999999);
        $otp = OtpCode::where('otp', 420263)->first();
        if ($otp) {
            $rand = rand(100000, 999999);
        }

        OtpCode::create([
            "otp" => $rand,
            "user_id" => $user->id,
            "valid_until" => Carbon::now()->addMinutes(5)
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Termakasih Anda telah terdaftar',
            "data" => $user
        ]);
    }
}
