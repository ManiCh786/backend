<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrationModel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class UserController extends Controller
{

    public function userInfo()
    {
        $authUserInfo = auth()->user();

        $userInfo = User::join('roles', 'users.roleId', '=', 'roles.roleId')
            ->select('roles.*', 'users.*')
            ->where('email', $authUserInfo->email)
            ->where('userId', $authUserInfo->userId)
            ->first();

        return $userInfo;
    }
    public function getAllUsers()
    {
        //     $userInfo = User::join('roles', 'users.roleId', '=', 'roles.roleId')
        //         ->select('users.*', 'roles.*')
        //         ->get();
        $userInfo = DB::table('users')
            ->join('roles', 'roles.roleId', '=', 'users.roleId')
            ->select('roles.roleName', 'users.*')
            ->get();

        return $userInfo;
    }
    public function getAllFacultyMembers()
    {
        $userInfo = DB::table('users')
            ->join('roles', 'roles.roleId', '=', 'users.roleId')
            ->where('roles.roleName', '=', 'faculty')
            ->select('roles.roleName', 'users.*')
            ->get();
        return $userInfo;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => "Field Values are not valid"], 200);
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $emailExits = User::where('email', $request->email)->first();
        if ($emailExits) {
            if (Hash::check($request->input('password'), $emailExits->password)) {
                if (auth()->attempt($data)) {
                    $userInfo = User::join('roles', 'users.roleId', '=', 'roles.roleId')
                        ->select('roles.*', 'users.*')
                        ->where('email', $request->input('email'))
                        ->where('password', Hash::check($request->input('password'), 'password'))
                        ->first();
                    $token = $userInfo->createToken('userLoginToken')->accessToken;
                    if ($request->user()->hasVerifiedEmail()) {
                        return response()->json(['message' => 'Login Approved', 'token' => $token, 'verifiedAddress' => '', 'email' => auth()->user()->email,'userId' => auth()->user()->userId, 'accountType' => $userInfo->roleName], 200);
                    } else {
                        // email/verify-email
                        return response()->json(['message' => 'Login Approved', 'token' => $token, 'verifiedAddress' => '', 'email' => auth()->user()->email,'userId' => auth()->user()->userId, 'accountType' => $userInfo->roleName], 200);
                    }
                } else {
                    return response()->json([
                        'message' => "Email or Password is Inorrect",
                    ], 403);
                }
            } else {
                return response()->json([
                    'message' => "Your password is incorrect !",

                ], 403);
            }
        } else {
            $emailRegistered = RegistrationModel::where('email', $request->email)->first();
            if (!$emailRegistered) {
                return response()->json([
                    'message' => "Email you entered does'nt exits !",
                ], 403);
            } else {
                return response()->json([
                    'message' => "Your Registratation is not approved yet !",

                ], 403);
            }
        }
    }
}
