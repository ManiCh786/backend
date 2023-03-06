<?php

namespace App\Http\Controllers;

use App\Models\CourseObjectivesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CourseObjectiveController extends Controller
{
    //
    public function getCourseObjective(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'courseId' => 'required|integer',

        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Course ID is Required !",
            ], 200);
        } else {

            $loggedInUserId = auth()->user()->userId;
            // $courseObjectives = DB::table('course_objectives')
            //     ->join('courses', 'courses.courseId', '=', 'course_objectives.courseId')
            //     // ->join('users','users.userId','=','')
            //     ->where('course_objectives.added_by', '=', $loggedInUserId)
            //     ->where('course_objectives.courseId', '=', $req->input('courseId'))
            //     // ->where('course_objectives.created_at', '>', '2021-00-00')
            //     ->select('courses.courseName', 'course_objectives.*')
            //     ->get();
            $courseObjectives = DB::table('course_objectives')
                ->leftJoin('objectives_breakdown', 'objectives_breakdown.objId', '=', 'course_objectives.objId')
                // ->join('users','users.userId','=','') 
                // ->where('course_outcomes.objId', '=', 'course_objectives.objId')
                ->where('course_objectives.added_by', '=', $loggedInUserId)
                ->where('course_objectives.courseId', '=', $req->input('courseId'))
                // ->whereNull('course_outcomes.outcomeTitle')
                ->whereNotNull('course_objectives.objName')

                // ->whereNull('course_outcomes.added_by')
                // ->where('course_objectives.created_at', '>', '2021-00-00')
                ->select('objectives_breakdown.*', 'course_objectives.*')
                ->get();

            return $courseObjectives;
        }
    }
    public function addCourseObjective(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'objName' => 'required|string|min:3',
            'outcome' => 'required|string|min:6',
            'outcomeBtLevel' => 'required|string|min:3',
            'courseId' => 'required|integer',
            'objWeightage'=>'required|integer',
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
            $addObjective = new CourseObjectivesModel();
            $addObjective->objName = $req->input('objName');
            $addObjective->outcome  = $req->input('outcome');
            $addObjective->courseId  = $req->input('courseId');
            $addObjective->outcomeBtLevel  = $req->input('outcomeBtLevel');
            $addObjective->added_by  = $loggedInUserId;
            
            $addObjective->weightage  = $req->input('objWeightage');

            $addObjective->created_at  = $req->input('created_at');
            $addObjective->updated_at  = $req->input('updated_at');
            if ($addObjective->save()) {
                return response([
                    'success' => true,
                    'message' => "Objective Added Succesfully !",
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
