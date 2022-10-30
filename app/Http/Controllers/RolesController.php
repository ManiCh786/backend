<?php

namespace App\Http\Controllers;

use App\Models\RolesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    //

    public function addrole(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'roleName' => 'required|string|min:3|max:30',
            'roleDesc' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => "Field Values are not valid  !"], 200);
        }
        $alreadyExits = RolesModel::where('roleName', $req->input('roleName'))->first();
        if (!$alreadyExits) {
            $addRole = new RolesModel();
            $addRole->roleName = $req->input('roleName');
            $addRole->roleDesc = $req->input('roleDesc');
            $addRole->created_at = $req->input('created_at');
            $addRole->updated_at = $req->input('updated_at');
            if ($addRole->save()) {
                return response()->json([
                    'success' => true,
                    'message' => "Role Added Succesfully",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "Role with this Name Already Exits !",

            ], 200);
            // return response()->json([
            //         'success' => false,
            //         'message' => 'Role with this Name Already Exits',
            //     ],200);
        }
    }
    public function deleteRole(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'roleId' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => "Id is required to delete !"], 403);
        }
        $checkIfExits = RolesModel::where('roleId', $req->input('roleId'))->first();
        if ($checkIfExits) {
            $roleId = $req->input('roleId');
            RolesModel::where('roleId', $roleId)->delete();
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Role Deleted Succesfully !',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Role does not Exits',
                ],
                200
            );
        }
    }
    public function getAllRoles()
    {
        return RolesModel::all();
    }
}
