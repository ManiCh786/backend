<?php

namespace App\Http\Controllers;

use App\Models\CoursesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\lectOutlineModel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class LecturesController extends Controller
{
    //

    public function uploadNewLecFile(Request $request)
    {
        $uploadedBy = auth()->user()->userId;
        $destination = 'uploads/faculty/outline/lectureFiles/' . $uploadedBy . '/';
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
    public function  approveOrRejectOutline(Request $req){
        $outlineId = $req->input('outlineId');
        $feedback = $req->input('approved');
        // assessmentId
        $validator = Validator::make($req->all(), [
            'outlineId' => 'required',
          
        ]);
        $added_by =  auth()->user()->userId;
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "outlineId is invalid!",
            ], 200);
        } else {
            $update = lectOutlineModel::where('outlineId', $outlineId)
        ->update([
            'approved' => $feedback,
            'approved_by'=>$added_by,
        ]);
        if($update){
            return response()->json([
                'success' => true,
                'message' => "Process Completed",
    
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => "Unknown Error Occured !",
    
            ], 200);
        }
       }
    }
    public function updateLectureOutline(Request $request){
        $uploadedBy = auth()->user()->userId;
        $outlineId = $request->input('outlineId');
        // assessmentId
        $validator = Validator::make($request->all(), [
            'outlineId' => 'required|integer',
            'file' => 'required|string',
            'relatedTopic'=>'required|string',
            'btLevel'=>'required|string',
            'courseObj'=>'required|string',
            'updated_at' => 'required',
          
        ]);
        $added_by =  auth()->user()->userId;
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "outline Id is invalid!",
            ], 200);
        } else {
            $addAssessment = lectOutlineModel::where('outlineId', $outlineId)
        ->update([
            'fileName' => $request->input('file'),
            'relatedTopic' => $request->input('relatedTopic'),
            'btLevel' => $request->input('btLevel'),
            'objectives' => $request->input('courseObj'),
            'approved'=>'no',
            'updated_at' => $request->input('updatedAt'),
          
        ]);
            // $addAssessment = AssessmentsModel::where('asId',$asId)->first();
            // // $addAssessment = new AssessmentsModel();
            // $addAssessment->senttoHod = "yes";
            if ($addAssessment) {
                return response()->json([
                    'success' => true,
                    'message' => "Updated Successfully",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);
            }
        }
    }
    
    public function uploadFileRecordToDatabase(Request $request)
    {

        // $weeks = $request->input('subject');
        $validator = Validator::make($request->all(), [
            'lectNo' => 'required|integer',
            'session' => 'required|string|min:4',
            'subject' => 'required|string',
            'weeks' => 'required|integer',
            'file' => 'required|string',
            'relatedTopic'=>'required|string',
            'btLevel'=>'required|string',
            'courseObj'=>'required|string',
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
            $addOutline = new lectOutlineModel();
            $addOutline->lecNo = $request->input('lectNo');
            $addOutline->session = $request->input('session');
            $addOutline->subject = $request->input('subject');
            $addOutline->weekNo = $request->input('weeks');
            $addOutline->fileName = $request->input('file');
            $addOutline->relatedTopic = $request->input('relatedTopic');
            $addOutline->btLevel = $request->input('btLevel');
            $addOutline->objectives = $request->input('courseObj');
            $addOutline->outline_added_by = $added_by;
            $addOutline->created_at = $request->input('created_at');
            $addOutline->updated_at = $request->input('updated_at');
            if ($addOutline->save()) {
                return response()->json([
                    'success' => true,
                    'message' => "Outline Added Succesfully",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);
            }
        }
    }
    public function uploadMoreLecFile(Request $request){
        $uploadedBy = auth()->user()->userId;
        $outlineId = $request->input('outlineId');
        // assessmentId
        $validator = Validator::make($request->all(), [
            'outlineId' => 'required|integer'
        ]);
        $added_by =  auth()->user()->userId;
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "outline Id is invalid!",
            ], 200);
          
         
        } else {
            if($request->input('file1')!=""){
                $addAssessment = lectOutlineModel::where('outlineId', $outlineId)
        ->update([
            'fileName1' => $request->input('file1'),
          
          
        ]);
        if ($addAssessment) {
            return response()->json([
                'success' => true,
                'message' => "Updated Successfully",

            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Unknown Error Occured !",

            ], 200);
        }
            }else if($request->input('file2')!=""){
                $addAssessment = lectOutlineModel::where('outlineId', $outlineId)
                ->update([
                    'fileName2' => $request->input('file2'),
                  
                  
                ]);
            }else if($request->input('file3')!=""){
                $addAssessment = lectOutlineModel::where('outlineId', $outlineId)
                ->update([
                    'fileName3' => $request->input('file3'),
                  
                  
                ]);
                if ($addAssessment) {
                    return response()->json([
                        'success' => true,
                        'message' => "Updated Successfully",
    
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => "Unknown Error Occured !",
    
                    ], 200);
                }
            }else if($request->input('file4')!=""){
                $addAssessment = lectOutlineModel::where('outlineId', $outlineId)
                ->update([
                    'fileName4' => $request->input('file4'),
                  
                  
                ]);
                if ($addAssessment) {
                    return response()->json([
                        'success' => true,
                        'message' => "Updated Successfully",
    
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
    public function getMyOutline()
    {

        $loggedInUserId = auth()->user()->userId;
        // $authUserInfo = auth()->user()->fName;
        $outline = DB::table('lecturesOutline') 
        ->leftJoin('users', function ($join) {
            $join->on('users.userId', '=', 'lecturesOutline.approved_by')
                 ->orWhereNull('lecturesOutline.approved_by');
        })
            // ->join('users', 'users.userId', '=', 'lecturesOutline.approved_by')
            // ->where('lecturesOutline.outline_added_by', '=', $loggedInUserId)
            // ->where('lecturesOutline.subject', '=', "SE kadksjklaslkdjlaks")
            // ->where('lecturesOutline.session', '=', "fall")
            // ->where('lecturesOutline.created_at', '=', "2023-00-00")
            ->select('lecturesOutline.*','users.*','lecturesOutline.created_at','lecturesOutline.updated_at')
            ->get();

        return $outline;
    }
    public function downloadOutlineFile(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'fileName' => 'required|string',
            'userId'=>'required'
        ]);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'message' => "File Name is Required !",
            ], 200);
        } else {
            $uploadedBy = $req->input('userId');
        $fileName = $req->input('fileName');
        // $fileName = "209393882135.pdf";
        $destination = public_path() . '/uploads/faculty/outline/lectureFiles/' . $uploadedBy . '/' . $fileName;
        return Response::download($destination, $fileName);
        // $file = Response::download($destination, $fileName);


    }

}

}
