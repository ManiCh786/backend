<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\StartEnrollmentModel;

use Illuminate\Support\Facades\DB;
class StartEnrollmentController extends Controller
{
    //
    public function getAllStartEnrollments()
    {
        $loggedInUserId = auth()->user()->userId;
        $allEnrollmentSchedule = DB::table('startenrollment')
        ->join('users','users.userId','=','startenrollment.added_by')
        ->join('roles', 'users.roleId', '=', 'roles.roleId')
        ->select('startenrollment.*','users.*','roles.*')
         
            ->get();

        return $allEnrollmentSchedule;
    }
    public function updateStartEnrollmentSchedule(Request $req){
        $seId =$req->input('seId');
        $validator = Validator::make($req->all(), [
            'seId' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => "Field Values are not valid  !"], 200);
        }else{
            $update = StartEnrollmentModel::where('seId', $seId)
            ->update([
                // 'startDate' => $req->input('startDate'),
                'endDate' => $req->input('endDate'),
            ]);
            if($update() != 1){
                return response()->json([
                    'success' => true,
                    'message' => "Enrollment Schedule Updated Successfully",

                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Error Ocurred",

                ], 200);
            }
        }
    }
    public function addNewStartEnrollmentSchedule(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'session' => 'required|string|min:3|max:30',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => "Field Values are not valid  !"], 200);
        }
        $alreadyExits = StartEnrollmentModel::where('session', $req->input('session'))->where('startDate',$req->input('startDate'))
        ->where('endDate',$req->input('endDate'))
        ->first();
        if(!$alreadyExits)
          {
            $added_by =  auth()->user()->userId;
           $add = new StartEnrollmentModel();
            $add->session = $req->input('session');
            $add->startDate = $req->input('startDate');
            $add->endDate = $req->input('endDate');
            $add->added_by = $added_by;
            $add->created_at = $req->input('created_at');
            $add->updated_at = $req->input('updated_at');
            if ($add->save()) {
                return response()->json([
                    'success' => true,
                    'message' => "Enrollment Schedule Added Successfully",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);
            }
        
          
        }else{
            return response()->json([
                'success' => true,
                'message' => "Enrollment Already Added ",

            ], 200);
        }
    }

}
