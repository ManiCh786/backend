<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AssessmentsModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class AssessmentsController extends Controller
{
    //
    public function addAssessment(Request $request)
    {

        // $weeks = $request->input('subject');
        $validator = Validator::make($request->all(), [
            'outlineId' => 'required|integer',
            'assessmentType' => 'required|string|min:4',
            'assFileName' => 'required|string',
            'created_at' => 'required',
            'updated_at' => 'required',
        ]);
        $added_by =  auth()->user()->userId;
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Field Values are not valid !",
            ], 200);
        } else {
            $addAssessment = new AssessmentsModel();
            $addAssessment->outlineId = $request->input('outlineId');
            $addAssessment->assessmentType = $request->input('assessmentType');
            $addAssessment->assFileName = $request->input('assFileName');
            $addAssessment->ass_added_by = $added_by;

            $addAssessment->created_at = $request->input('created_at');
            $addAssessment->updated_at = $request->input('updated_at');
            if ($addAssessment->save()) {
                return response()->json([
                    'success' => true,
                    'message' => "Assessment Added Succesfully",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);
            }
        }
    }
 
    public function sendResultToHod(Request $request)
    {
     
        $asId = $request->input('assessmentId');
        // assessmentId
        $validator = Validator::make($request->all(), [
            'assessmentId' => 'required|integer',
        ]);
        $added_by =  auth()->user()->userId;
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "Assessment Id is invalid!",
            ], 200);
        } else {
            $addAssessment = AssessmentsModel::where('asId', $asId)
        ->update([
            'senttoHod' => 'yes',
          
        ]);
            // $addAssessment = AssessmentsModel::where('asId',$asId)->first();
            // // $addAssessment = new AssessmentsModel();
            // $addAssessment->senttoHod = "yes";
            if ($addAssessment) {
                return response()->json([
                    'success' => true,
                    'message' => "Result Send To HOD",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);
            }
        }
    }
    public function uploadAssessmentFile(Request $request)
    {
      
    $uploadedBy = auth()->user()->userId;
        $destination = 'uploads/faculty/assessments/' . $uploadedBy . '/';
        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->getClientOriginalName();
            $fileSize = $request->file('file')->getSize();
            $fileExtension = $request->file('file')->getClientOriginalExtension();
            $oneMb = 1000000; #1mb = 1000000 bytes
            if ($fileSize > ($oneMb * 50)) {
                return response()->json([
                    'success' => false,
                    'message' => "File Size Limit Exceeded ! Maximun Limit is 50 mb" . $fileSize . $fileExtension,

                ], 200);
            } else if ($fileExtension != 'pdf' && $fileExtension != 'docx') {

                return response()->json([
                    'success' => false,
                    'message' => "File Format mus be  PDF OR DOCX " . $fileExtension,

                ], 200);
            } else if (file_exists($destination . $fileName)) {
                return response()->json([
                    'success' => false,
                    'message' => "File with this name already exits ! " . $fileName . $fileExtension,

                ], 200);
            } else {
                $request->file('file')->move($destination, $fileName);

                return response()->json([
                    'success' => true,
                    'message' =>  $fileName,

                ], 200);
            }
        } else {

            return response()->json([
                'success' => false,
                'message' => "ERROR ! Attach a File To Upload !",

            ], 200);
        }
    }
    public function getAssessments()
    {

        $loggedInUserId = auth()->user()->userId;
        // $authUserInfo = auth()->user()->fName;
        $outline = DB::table('assessments')
        ->join('lecturesOutline','lecturesOutline.outlineId','=','assessments.outlineId')
            // ->where('assessments.ass_added_by', '=', $loggedInUserId)
            ->select('assessments.*','lecturesOutline.*')
            ->get();

        return $outline;
    }
    public function downloadAssessmentFile(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'fileName' => 'required|string',
            'userId'=>'required|integer',
        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "File Name is Required !",
            ], 200);
        } else {
      
        $uploadedBy = $req->input('userId');
        $fileName = $req->input('fileName');
        $destination =  'uploads/faculty/assessments/' . $uploadedBy . '/' . $fileName;
        return Response::download($destination, $fileName);
    }
}
}
