<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ObjectivesBreakdownModel;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class ObjectiveBreakdownController extends Controller
{
    //
    
    public function addBreakdownStructure(Request $req)
    {
        $added_by =  auth()->user()->userId;
        $data = $req->input('data');
  
        foreach ($data as $eachData) {
            $alreadyExits = ObjectivesBreakdownModel::where('objId',$eachData['objId'])->first();
            if (!$alreadyExits) {
            $add = new ObjectivesBreakdownModel();
            $add->objId = $eachData['objId'];
            $add->quiz = $eachData['quiz'];
            $add->assignment = $eachData['assignment'];
            $add->presentation = $eachData['presentation'];
            $add->project = $eachData['project'];
            $add->added_by = $added_by;
            $add->created_at = $eachData['created_at'];
            $add->updated_at = $eachData['updated_at'];
           
            if ($add->save()) {
                return response()->json([
                    'success' => true,
                    'message' => "Breakdown added Succesfully",

                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => "Unknown Error Occured !",

                ], 200);
            }
            }else {
                return response()->json([
                    'success' => false,
                    'message' => " Already Exits !",
    
                ], 200);
        }
            
        
        
        }


        // $validator = Validator::make($req->all(), [
        //     'objId' => 'required|integer',
        //     'quiz' => 'required|integer',
        //     'assignment' => 'required|integer',
        //     'presentation' => 'required|integer',
        //     'project' => 'required|integer',

        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['success' => false, 'message' => "Field Values are not valid  !"], 200);
        // }
      
    }
}
