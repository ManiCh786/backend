<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseOutcomesModel;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CourseOutcomeController extends Controller
{
    //
    public function getCourseOutcomes(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'objId' => 'required|integer',

        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Objective is Required !",
            ], 200);
        } else {

            $loggedInUserId = auth()->user()->userId;
            $courseOutcomes = DB::table('course_outcomes')
                ->join('course_objectives', 'course_objectives.objId', '=', 'course_outcomes.objId')
                // ->join('users','users.userId','=','')
                // ->where('course_outcomes.outcome_added_by', '=', $loggedInUserId) 
                ->where('course_outcomes.objId', '=', $req->input('objId'))
                // ->where('course_objectives.created_at', '>', '2021-00-00')
                ->select('course_outcomes.*', 'course_objectives.*')
                ->get();
            return $courseOutcomes;
        }
    }
    public function addCourseOutcomes(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'objId' => 'required|integer',
            'outcomeTitle' => 'required|string',
            'outComeDesc' => 'required|string',
            'created_at' => 'required',
            'updated_at' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Field Values are not valid !",
            ], 200);
        } else {

            $loggedInUserId = auth()->user()->userId;
            $addOutcome = new CourseOutcomesModel();
            $addOutcome->objId = $req->input('objId');
            $addOutcome->outcomeTitle  = $req->input('outcomeTitle');
            $addOutcome->outcomeDesc  = $req->input('outComeDesc');
            $addOutcome->outcome_added_by  = $loggedInUserId;
            $addOutcome->created_at  = $req->input('created_at');
            $addOutcome->updated_at  = $req->input('updated_at');
            if ($addOutcome->save()) {
                return response([
                    'success' => true,
                    'message' => "OutCome Added Succesfully !",
                ], 200);
            } else {
                return response([
                    'success' => false,
                    'message' => "Unknown Error Occured !",
                ], 200);
            }
        }
    }
}
