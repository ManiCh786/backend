<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\assBreakdownModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
class assBreakdownController extends Controller
{
    //
    public function addAssessmentBreakdown(Request $request)
    {

        $added_by =  auth()->user()->userId;
        $data = $request->input('data');
     
        foreach ($data as $eachData) {
            // $alreadyExits = assBreakdownModel::where('ploId',$eachData['ploId'])->first();
            // if (!$alreadyExits) {
            $add = new assBreakdownModel(); 
            $add->ploId = $eachData['ploId'];
            $add->objective = $eachData['objective'];
            $add->assessmenttype = $eachData['assessmentType'];
            $add->btLevel = $eachData['bloomTaxonomyLevel'];
            $add->Qno = $eachData['questionNumber'];
            $add->added_by = $added_by;

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
            // }else {
            //     return response()->json([
            //         'success' => false,
            //         'message' => " Already Exits !",
    
            //     ], 200);
        // }
    
        }
    }
}
