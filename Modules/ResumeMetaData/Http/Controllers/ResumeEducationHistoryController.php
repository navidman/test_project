<?php

namespace Modules\ResumeMetaData\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\ResumeMetaData\Entities\ResumeMetaData;
use Modules\ResumeMetaData\Http\Requests\EducationHistoryRequest;

class ResumeEducationHistoryController extends Controller
{
    /*
     * Get Data
     * Route: /api/education-history
     * GET
     * */
    public function getOwnerEducationHistory()
    {
        $Resume = ResumeManager::where('uid', auth('sanctum')->user()->id)->first();
        $MetaDataFetched = ResumeMetaData::where('resume_id', $Resume->id)->where('type', 'education_history')->orderBy('meta_data->date', 'asc')->get();

        foreach ($MetaDataFetched as $key => $item) {
            $MetaDataFetched[$key]['meta_data'] = json_decode($item->meta_data);
        }
        return response()->json($MetaDataFetched);
    }

    /*
     * Store Data
     * Route: /api/education-history
     * POST
     * */
    public function store(EducationHistoryRequest $request)
    {
        $Resume = ResumeManager::where('uid', auth('sanctum')->user()->id)->first();
        $MetaDataFetchedData = [];
        $MetaDataFetchedData['resume_id'] = $Resume->id;
        $MetaDataFetchedData['type'] = 'education_history';
        $MetaDataFetchedData['meta_data'] = json_encode([
            'field_of_study' => $request->field_of_study,
            'grade' => $request->grade,
            'university' => $request->university,
            'date' => $request->date,
            'to_date' => $request->to_date,
        ]);

        if (ResumeMetaData::create($MetaDataFetchedData)) {
            return response()->json(['status' => 200]);
        }
    }

    /*
     * Update Data
     * Route: /api/education-history
     * PUT
     * */
    public function update(EducationHistoryRequest $request)
    {
        $ResumeMetaData = ResumeMetaData::find($request->id);
        $Resume = ResumeManager::find($ResumeMetaData->resume_id);
        if (auth()->user('sanctum')->id == $Resume->uid) {
            $MetaDataFetchedData = [];
            $MetaDataFetchedData['meta_data'] = json_encode([
                'field_of_study' => $request->field_of_study,
                'grade' => $request->grade,
                'university' => $request->university,
                'date' => $request->date,
                'to_date' => $request->to_date,
            ]);

            if ($ResumeMetaData->update($MetaDataFetchedData)) {
                return response()->json(['status' => 200]);
            }
        }else {
            return response()->json(['status' => 401]);
        }
    }

    /*
 * Delete Data
 * Route: /api/education-history
 * DELETE
 * */
    public function delete(Request $request)
    {
        $ResumeMetaData = ResumeMetaData::find($request->id);
        $Resume = ResumeManager::find($ResumeMetaData->resume_id);

        if (auth()->user('sanctum')->id == $Resume->uid) {
            $ResumeMetaData->delete();
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 401]);
        }
    }
}
