<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\AssesmentBreakdownModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class AssessmentBreakdownController extends Controller
{
    //
    public function addAssessmentBreakdown(Request $request)
    {

        $added_by =  auth()->user()->userId;
        $data = $request->input('data');
 
        foreach ($data as $eachData) {
            $alreadyExits = AssesmentBreakdownModel::where('ploId',$eachData['ploId'])->first();
            if (!$alreadyExits) {
            $add = new AssesmentBreakdownModel(); 
            $add->ploId = $eachData['ploId'];
            $add->objective = $eachData['objective'];
            $add->assessmenttype = $eachData['assessmentType'];
            $add->btLevel = $eachData['bloomTaxonomyLevel'];
            $add->Qno = $eachData['questionNumber'];
            $add->added_by = $added_by;
            // $add->updated_at = "0000-00-00";
            // $add->created_at ="0000-00-00";

           
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
    
        }}

}
