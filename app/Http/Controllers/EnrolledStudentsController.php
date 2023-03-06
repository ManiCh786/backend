<?php

namespace App\Http\Controllers;
use App\Models\EnrolledStudentsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EnrolledStudentsController extends Controller
{

   //
   public function enrollNewCourse(Request $req)
   {
    $validator = Validator::make($req->all(), [
        'userId' => 'required',
        'courseId' => 'required',
        'session' => 'required|string',
        'startDate'=>'required'
    ]);
    if ($validator->fails()) {
        return response()->json(['success' => false, 'message' => "Field Values are not valid  !"], 200);
    }
    else  {
        $alreadyExits = EnrolledStudentsModel::where('userId', $req->input('userId'))
        ->where('courseId', $req->input('courseId'))->where('session', $req->input('session'))
        ->first();
        if($alreadyExits){
            return response()->json([
                'success' => false,
                'message' => "You have Already Enrolled this course !",

            ], 200);
        }else{
            $added_by =  auth()->user()->userId;
            $enroll = new EnrolledStudentsModel();
             $enroll->userId = $req->input('userId');
             $enroll->courseId = $req->input('courseId');
             $enroll->session = $req->input('session');
             $enroll->enrolled_by = $added_by;
             $enroll->startDate = $req->input('startDate');
             $enroll->created_at = $req->input('created_at');
             $enroll->updated_at = $req->input('updated_at');
             if ($enroll->save()) {
                 return response()->json([
                     'success' => true,
                     'message' => "You have Enrolled the Course Successfully",
     
                 ], 200);
             } else {
                 return response()->json([
                     'success' => false,
                     'message' => "Unknown Error Occured !",
     
                 ], 200);
             }
        }
      
    
      
    }
   }
   public function completeCourse(Request $req){
    $completionDate = $request->input('completionDate');
    // assessmentId
    $validator = Validator::make($request->all(), [
        'completionDate' => 'required',
      
    ]);
    $added_by =  auth()->user()->userId;
    if ($validator->fails()) {
        return response([
            'success' => false,
            'message' => "completionDate is invalid!",
        ], 200);
    } else {
        $addAssessment = AssessmentsModel::where('asId', $asId)
    ->update([
        'completionDate' => $completionDate,
      
    ]);
    if($addAssessment){
        return response()->json([
            'success' => true,
            'message' => "Course Completed !",

        ], 200);
    }else{
        return response()->json([
            'success' => false,
            'message' => "Unknown Error Occured !",

        ], 200);
    }
   }}
   public function getEnrolledStudents()
   {

           $loggedInUserId = auth()->user()->userId;
           $enrolledStudents = DB::table('enrolledstudents')
               ->join('courses', 'courses.courseId', '=', 'enrolledstudents.courseId')
               ->join('users', 'users.userId', '=', 'enrolledstudents.userId')
            //    ->where('users.userId', '=', $loggedInUserId)
               ->select('enrolledstudents.*','users.*', 'courses.*','enrolledstudents.created_at')
               ->get();
           return $enrolledStudents;
       }
//    }
}
