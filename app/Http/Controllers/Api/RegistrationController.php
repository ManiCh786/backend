<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistrationModel;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    //
    public function registeraNewUser(Request $req)
    {
        $register = new RegistrationModel();
        $validator = Validator::make($req->all(), [
            'fName' => 'required|string',
            'lName' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|min:10|numeric',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, true, 'message' => "Field Values are not valid  !"], 403);
        } else {
            $checkAlreadyRegistered = RegistrationModel::where('email', $req->input('email'))->first();
            $checkAlreadyHaveAccount = User::where('email', $req->input('email'))->first();
            if ($checkAlreadyHaveAccount == "" && $checkAlreadyRegistered == "") {
                $validator = Validator::make($req->all(), [
                    'fName' => 'required|string',
                    'lName' => 'required|string',
                    'email' => 'required|string',
                    'phone' => 'required|min:10|numeric',
                    'password' => 'required|string|min:6',
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => "Field Values are not valid  !"], 200);
                }
                $register = new RegistrationModel();
                $register->fName = $req->input('fName');
                $register->lName = $req->input('lName');
                $register->email = $req->input('email');
                $register->phone = $req->input('phone');
                $register->password = Hash::make($req->input('password'));
                $register->created_at = $req->input('created_at');
                $register->updated_at = $req->input('updated_at');
                if ($register->save()) {
                    return response()->json([
                        'success' => true,
                        'message' => "Account Created Succesfully",
                        200
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Unknown Error Occured !",
                        403
                    ]);
                }
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'This Email Already Exits !',
                    ],
                    403
                );
            }
        }
    }
    public function deleteRegUser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'regId' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => "Id is required to delete !"], 403);
        }
        $checkIfExits = RegistrationModel::where('regId', $req->input('regId'))->first();
        if ($checkIfExits) {
            $regId = $req->input('regId');
            RegistrationModel::where('regId', $regId)->delete();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User Deleted Succesfully !',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User does not exits !',
                ],
                403
            );
        }
    }
    public function getAllRegisterdUsers()
    {
        return RegistrationModel::all();
    }
    public function assignRoleToRegisteredUser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'regId' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => "Validation Failed !"], 403);
        } else {
            $checkUserExits = RegistrationModel::where('regId', $req->input('regId'))->first();
            if ($checkUserExits) {
                $user = RegistrationModel::where('regId', $req->input('regId'))->get();
                foreach ($user as $key => $value) {
                    // return response()->json(
                    //     [
                    //         'success' => false,
                    //         "user" => $user,
                    //         'regId' => $value->regId,
                    //         'fName' => $value->fName,
                    //         'addedBy' => $value->email,
                    //         'roleId' => $req->roleId,

                    //     ],
                    //     200
                    // );

                    $user =  User::create([
                        'regId' => $value->regId,
                        'fName' => $value->fName,
                        'lName' => $value->lName,
                        'email' => $value->email,
                        'phone' => $value->phone,
                        'password' => $value->password,
                        'roleId' => $req->roleId,
                        'added_by' => auth()->user()->email,
                        'registered_at' => $value->created_at,
                        'created_at' => $req->created_at,
                        'updated_at' => $req->updated_at,
                    ]);
                    $token = $user->createToken('userLoginToken')->accessToken;
                    RegistrationModel::where('regId', $req->regId)->delete();
                    $checkIfExits = RegistrationModel::where('regId', $req->regId)->first();
                    if (!$checkIfExits) {
                        return response()->json(
                            [
                                'success' => true,
                                'message' => "Role Assigned Successfuly !",
                                'token' => $token,
                            ],
                            200
                        );
                    } else {
                        return response()->json(
                            [
                                'success' => false,
                                'message' => "Unknown Error Occured !",
                            ],
                            403
                        );
                    }
                }
            } else {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'User does not Exits !',
                    ],
                    403
                );
            }
        }
    }
}