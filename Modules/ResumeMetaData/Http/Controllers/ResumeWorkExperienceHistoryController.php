<?php

namespace Modules\ResumeMetaData\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\ResumeMetaData\Entities\ResumeMetaData;
use Modules\ResumeMetaData\Http\Requests\WorkExperienceHistoryRequest;

class ResumeWorkExperienceHistoryController extends Controller
{
    /*
     * Store Work Experience
     * Route: /api/work-experience-history
     * GET
     * */
    public function getOwnerWorkExperienceHistory()
    {
        $Resume = ResumeManager::where('uid', auth('sanctum')->user()->id)->first();
        $WorkExperienceHistory = ResumeMetaData::where('resume_id', $Resume->id)->where('type', 'work_history')->orderBy('meta_data->date', 'asc')->get();

        foreach ($WorkExperienceHistory as $key => $item) {
            $WorkExperienceHistory[$key]['meta_data'] = json_decode($item->meta_data);
        }
        return response()->json($WorkExperienceHistory);
    }

    /*
     * Store Work Experience
     * Route: /api/work-experience-history
     * POST
     * */
    public function store(WorkExperienceHistoryRequest $request)
    {
        $Resume = ResumeManager::where('uid', auth('sanctum')->user()->id)->first();
        $WorkExperienceHistoryData = [];
        $WorkExperienceHistoryData['resume_id'] = $Resume->id;
        $WorkExperienceHistoryData['type'] = 'work_history';
        $WorkExperienceHistoryData['meta_data'] = json_encode([
            'company_name' => $request->company_name,
            'job_title' => $request->job_title,
            'cooperation_type' => $request->cooperation_type,
            'date' => $request->date,
            'to_date' => $request->to_date,
            'desc' => $request->desc,
        ]);

        if (ResumeMetaData::create($WorkExperienceHistoryData)) {
            return response()->json(['status' => 200]);
        }
    }

    /*
     * Store Work Experience
     * Route: /api/work-experience-history
     * PUT
     * */
    public function update(WorkExperienceHistoryRequest $request)
    {
        $ResumeMetaData = ResumeMetaData::find($request->id);
        $Resume = ResumeManager::find($ResumeMetaData->resume_id);
        if (auth('sanctum')->user()->id == $Resume->uid) {
            $WorkExperienceHistoryData = [];
            $WorkExperienceHistoryData['meta_data'] = json_encode([
                'company_name' => $request->company_name,
                'job_title' => $request->job_title,
                'cooperation_type' => $request->cooperation_type,
                'date' => $request->date,
                'to_date' => $request->to_date,
                'desc' => $request->desc,
            ]);

            if ($ResumeMetaData->update($WorkExperienceHistoryData)) {
                return response()->json(['status' => 200]);
            }
        }else {
            return response()->json(['status' => 401]);
        }
    }

    /*
 * Store Work Experience
 * Route: /api/work-experience-history
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
