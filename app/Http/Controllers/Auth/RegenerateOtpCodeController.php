<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class RegenerateOtpCodeController extends Controller
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
            'email' => ['email', 'required']
        ]);

        $user = User::where("email", $request->email)->first();
        if (!$user) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Email Tidak ditemukan'
            ], 200);
        }

        OtpCode::where("user_id", $user->id)
            ->update(['otp' => rand(100000, 999999), "valid_until" => Carbon::now()->addMinutes(5)]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Silahkan Cek Email',
            'data' => $user
        ], 200);
    }
}
