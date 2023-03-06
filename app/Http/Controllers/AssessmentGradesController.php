<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AssessmentsMarksModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class AssessmentGradesController extends Controller
{
    //
    public function getAssessmentsMarks(Request $req)
    {

        
        $marks = DB::table('assessment_marks')
        ->join('assessments','assessments.asId','=','assessment_marks.assessment_id')
        ->join('users','users.userId','=','assessment_marks.student_id')
        // ->where('assessment_marks.assessment_id', '=', $req->input('assessmentId'))
            ->select('users.*','assessments.*','assessment_marks.*')
            ->get();

        return $marks;
    // }
    }
    public function getEveryInfoWithMarks(){
        $marks = DB::table('lecturesoutline')
        ->join('assessments','assessments.outlineId','=','lecturesoutline.outlineId')
        ->join('assessment_marks','assessments.asId','=','assessment_marks.assessment_id')
        ->join('users','users.userId','=','assessment_marks.student_id')
        // ->where('assessment_marks.assessment_id', '=', $req->input('assessmentId'))
            ->select('users.*','assessments.*','assessment_marks.*','lecturesoutline.*')
            ->get();
        return $marks;

    }
    //
    public function addAssessmentMarks(Request $request)
    {

        $added_by =  auth()->user()->userId;
        $marks = $request->input('students');
 
        foreach ($marks as $eachMarks) {


            $addAssessment = new AssessmentsMarksModel();
            $addAssessment->assessment_id = $eachMarks['assessment_id'];
            $addAssessment->qno = $eachMarks['qno'];
            $addAssessment->obtmarks =$eachMarks['obtmarks'] ;
            $addAssessment->total_marks = $eachMarks['total_marks'] ;
            $addAssessment->student_id =$eachMarks['student_id'];
            $addAssessment->objName =$eachMarks['objName'];
            $addAssessment->added_by = $added_by;
            $addAssessment->created_at = $eachMarks['created_at'];
            $addAssessment->updated_at = $eachMarks['updated_at'];
            if ($addAssessment->save()) {
                return response()->json([
                    'success' => true,
                    'message' => "Assessment Marks Added Succesfully",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);

            }

    };
}
        // Save the $people array to your database or perform other operations
        // return response()->json(['success' => true]);
        // $weeks = $request->input('subject');
        // $validator = Validator::make($request->all(), [
        //     'assessmentId' => 'required|integer',
        //     'qno' => 'required|integer',

        //     'obtMarks' => 'required|integer',
        //     'totalMarks' => 'required|integer',
        //     'student_id' =>'required|integer',
        //     'created_at' => 'required',
        //     'updated_at' => 'required',
        // ]);

        // $added_by =  auth()->user()->userId;
        // if ($validator->fails()) {
        //     return response([
        //         'success' => false,
        //         'message' => "Field Values are not valid !",
        //     ], 200);
        // } else {
            // $addAssessment = new AssessmentsMarksModel();
            // $addAssessment->assessment_id = $request->input('assessmendId');
            // $addAssessment->qno = $request->input('qno');
            // $addAssessment->obtmarks = $request->input('obtMarks');
            // $addAssessment->total_marks = $request->input('totalMarks');
            // $addAssessment->student_id = $request->input('student_id');


            // $addAssessment->added_by = $added_by;

            // $addAssessment->created_at = $request->input('created_at');
            // $addAssessment->updated_at = $request->input('updated_at');
            // if ($addAssessment->save()) {
            //     return response()->json([
            //         'success' => true,
            //         'message' => "Assessment Marks Added Succesfully",

            //     ], 200);
            // } else {
            //     return response()->json([
            //         'success' => false,
            //         'message' => "Unknown Error Occured !",

            //     ], 200);
            // }


            }
