<?php

namespace App\Http\Controllers;

use App\Models\CourseObjectivesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CourseObjectiveController extends Controller
{
    //
    public function getCourseObjective()
    {
        $courseObjectives = DB::table('course_objectives')
            ->join('courses', 'courses.courseId', '=', 'course_objectives.courseId')
            // ->join('users','users.userId','=','')
            ->where('course_objectives.added_by', '=', '3')
            // ->where('course_objectives.created_at', '>', '2021-00-00')
            ->select('courses.*', 'course_objectives.*')
            ->get();
        return $courseObjectives;
    }
    public function addCourseObjective(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'objName' => 'required|string|min:3',
            'objDesc' => 'required|string|min:6',
            'courseId' => 'required|integer',
            'added_by' => 'required|integer',
            'created_at' => 'required',
            'updated_at' => 'required',
        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Field Values are not valid !",
            ], 200);
        } else {
            $addObjective = new CourseObjectivesModel();
            $addObjective->objName = $req->input('objName');
            $addObjective->objDesc  = $req->input('objDesc');
            $addObjective->courseId  = $req->input('courseId');
            $addObjective->added_by  = $req->input('added_by');
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
