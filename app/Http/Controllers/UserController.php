<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{

    function LoginPage():View
    {
        return view('pages.auth.login-page');
    }

    function RegistrationPage():View
    {
        return view('pages.auth.registration-page');
    }

    function SendOtpPage():View
    {
        return view('pages.auth.send-otp-page');
    }

    function VerifyOtpPage():View
    {
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage():View
    {
        return view('pages.auth.reset-pass-page');
    }

    function DasboardPage():View
    {
        return view('pages.dashboard.dashboard-page');
    }

    function UserProfilePage():View
    {
        return view('pages.dashboard.profile-page');
    }










    function UserRegistration(Request $request)
    {
        try
        {
            User::create([
                'firstName'     => $request->input('firstName'),
                'lastName'      => $request->input('lastName'),
                'email'         => $request->input('email'),
                'mobile'        => $request->input('mobile'),
                'password'      => $request->input('password'),
            ]);

            return response()->json([
                'status'    =>'success',
                'message'   =>'User Registration successful'
            ]);
        }
        catch(Exception $exception)
        {
            return response()->json([
                'status'=>'failed',
                'message'   => $exception->getMessage()
            ]);
        }
    }

    function UserLogin(Request $request)
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->select('id')->first();

            if($count!==null)
            {
                // User login -> issue jwt token
                $token = JWTToken::CreateToken($request->input('email'), $count->id);
                return response()->json([
                    'status'=>'success',
                    'message'=>'Login successful',
                    // 'token'=>$token
                ])->cookie('token', $token, time()+60*24*30);
            }
            else
            {
                return response()->json([
                    'status'=>'failed',
                    'message'=>'unauthorized'
                ]);
            }
    }

    function SendOTPCode(Request $request)
    {
        $email  = $request->input('email');
        $otp    = rand(1000, 9999);

        $count  = User::where('email', '=', $email)->count();

        if($count == 1)
        {
            // Send Otp to the email
            Mail::to($email)->send(new OTPMail($otp));
            // Update the otp in the database because default is 0
            User::where('email', '=', $email)->update(['otp'=>$otp]);

            return response()->json([
                'status'=>'success',
                'message'=>'4 digit OTP code has be sent to the email'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ]);
        }
    }

    function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email','=' ,$email)->where('otp','=' ,$otp)->count();

        if($count == 1)
        {
            // update otp in the database
            User::where('email', '=', $email)->update(['otp'=>'0']);
            // Issue password reset token
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
                return response()->json([
                    'status'=>'success',
                    'message'=>'OTP verification successful',
                    // 'token'=>$token
                ])->cookie('token', $token, 60*24*30);

        }
        else
        {
            return response()->json([
                'status'=>'failed',
                'message'=>'OTP does not matched'
            ]);
        }
    }

    function ResetPassword(Request $request)
    {
        try
        {
            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', '=', $email)->update(['password'=>$password]);

            return response()->json([
                'status'=>'success',
                'message'=>'Password reset successful'
            ]);
        }
        catch(Exception $exception)
        {
            return response()->json([
                'status'=>'failed',
                'message'=>'Something went wrong'
            ]);
        }
    }

    function UserLogout()
    {
        return redirect("/userLogin")->cookie('token','', -1);
    }

    function UserProfile(Request $request)
    {
        try
        {
            $email  = $request->header('email');
            $user = User::where('email','=' ,$email)->first();
            return response()->json([
                'status'=>'success',
                'message'=>'Request Successsful',
                'data' => $user
            ], 200);
        }
        catch(Exception $exception)
        {
            return response()->json([
                'status'=>'failed',
                'message'=>'Somethin went wrong'
            ]);
        }
    }

    function UpdateProfile(Request $request)
    {
        try
        {
            $firstName      = $request->input('firstName');
            $lastName       = $request->input('lastName');
            $email          = $request->header('email');
            $mobile         = $request->input('mobile');
            $password       = $request->input('password');

            User::where('email', '=', $email)->update([
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password
            ]);
            return response()->json([
                'status'=>'success',
                'message'=>'Profile update successful'
            ], 200);
        }catch(Exception $exception)
        {
            return response()->json([
                'status'=>'failed',
                'message'=>'Something went wrong'
            ]);
        }
    }
}
