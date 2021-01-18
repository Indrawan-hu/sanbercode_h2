<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OtpCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $otp_code = OtpCode::where("otp", $request->otp)->first();

        if (!$otp_code) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP Code Tidak ditemukan'
            ], 200);
        }

        $now = Carbon::now();

        if ($now > $otp_code->valid_until) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'OTP Code Sudah kadaluarsa, Harap Generate Ulang'
            ], 200);
        }

        //UPDATE User
        $user = User::find($otp_code->user_id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        //DELETE OTP
        $otp_code->delete();
        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'OTP Code Anda benar, Email sudah terverifikasi',
            'data' => $user
        ], 200);
    }
}
