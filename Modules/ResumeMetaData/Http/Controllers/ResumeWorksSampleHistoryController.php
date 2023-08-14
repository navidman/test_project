<?php

namespace Modules\ResumeMetaData\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\FileLibrary\Http\Controllers\FileLibraryController;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\ResumeMetaData\Entities\ResumeMetaData;
use Modules\ResumeMetaData\Http\Requests\EducationHistoryRequest;
use Modules\ResumeMetaData\Http\Requests\WorksSampleHistoryRequest;

class ResumeWorksSampleHistoryController extends Controller
{
    /*
     * Get Data
     * Route: /api/education-history
     * GET
     * */
    public function getOwnerWorksSampleHistory()
    {
        $Resume = ResumeManager::where('uid', auth('sanctum')->user()->id)->first();
        $MetaDataFetched = ResumeMetaData::where('resume_id', $Resume->id)->where('type', 'works_sample_history')->orderBy('meta_data->date', 'asc')->get();

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
    public function store(WorksSampleHistoryRequest $request)
    {
        $Resume = ResumeManager::where('uid', auth('sanctum')->user()->id)->first();
        $MetaDataFetchedData = [];
        $MetaDataFetchedData['resume_id'] = $Resume->id;
        $MetaDataFetchedData['type'] = 'works_sample_history';
        $MetaDataFetchedData['meta_data'] = json_encode([
            'type' => $request->type,
            'attachments' => $request->file('attachments') ? HomeController::GetAvatar('313', '626', FileLibraryController::upload($request->file('attachments'), 'image', 'works-sample-history/thumbnail', 'works-sample-history', array([313, 192, 'resize'], [626, 384, 'resize']))) : null,
            'title' => $request->title,
            'url' => $request->url,
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
    public function update(WorksSampleHistoryRequest $request)
    {
        $ResumeMetaData = ResumeMetaData::find($request->id);
        $Resume = ResumeManager::find($ResumeMetaData->resume_id);
        if (auth('sanctum')->user()->id == $Resume->uid) {
            $MetaDataFetchedData = [];
            $MetaDataFetchedData['meta_data'] = json_encode([
                'type' => $request->type,
                'attachments' => $request->file('attachments') ? HomeController::GetAvatar('313', '626', FileLibraryController::upload($request->file('attachments'), 'image', 'works-sample-history/thumbnail', 'works-sample-history', array([313, 192, 'resize'], [626, 384, 'resize']))) : $request->attachments,
                'title' => $request->title,
                'url' => $request->url,
            ]);

            if ($ResumeMetaData->update($MetaDataFetchedData)) {
                return response()->json(['status' => 200]);
            }
        } else {
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

        if (auth('sanctum')->user()->id == $Resume->uid) {
            $ResumeMetaData->delete();
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 401]);
        }
    }
}
