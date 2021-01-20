<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisterEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Mail\UserRegisterMail;
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

        event(new UserRegisterEvent($user));

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Termakasih Anda telah terdaftar',
            "data" => $user
        ]);
    }
}
