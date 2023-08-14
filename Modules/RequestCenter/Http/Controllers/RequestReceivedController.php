<?php

namespace Modules\RequestCenter\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\RequestCenter\Entities\RequestCenter;
use Modules\RequestCenter\Entities\RequestReceived;
use Modules\ResumeManager\Entities\ResumeManager;

class RequestReceivedController extends Controller
{
    /**
     * Get Request Received
     * @api /request-center/received/{id}
     * @Method GET
     * */
    public function GetRequestReceived()
    {
        $RequestReceived = RequestReceived::orderBy('updated_at', 'desc')->paginate(20);

        if ($RequestReceived) {
            foreach ($RequestReceived as $key => $item) {
                $RequestCenter = RequestCenter::find($item->request_center_id);
                $RequestTitle = '';
                if ($RequestCenter->field === 'select_resume') {
                    if ($item->field === 'all') {
                        $RequestTitle = 'تمام رزومه ها';
                    } else {
                        $GetName = ResumeManager::select('uid')->find($item->field);
                        $RequestTitle = HomeController::GetUserData($GetName->uid);
                    }
                } elseif ($RequestCenter->field === 'select_ads') {
                    if ($item->field === 'all') {
                        $RequestTitle = 'برای تمام نیازمندی ها';
                    } else {

                        $GetName = EmploymentAdvertisement::select('title')->find($item->field);
                        $RequestTitle = 'برای نیازمندی ' . $GetName->title;
                    }
                }

                $RequestReceived[$key]['title'] = $RequestCenter->title . ' ' . $RequestTitle;
                $RequestReceived[$key]['amount'] = $RequestCenter->amount;
            }
        }

        return view('requestcenter::request-received.index', compact('RequestReceived'));
    }

    /**
     * Get Request Received
     * @api /api/request-received
     * @Method GET
     * */
    public function RequestReceived()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $RequestReceived = RequestReceived::where('uid', $User)->orderBy('updated_at', 'desc')->get();

        if ($RequestReceived) {
            foreach ($RequestReceived as $key => $item) {
                $RequestCenter = RequestCenter::find($item->request_center_id);
                $RequestTitle = '';
                if ($RequestCenter->field === 'select_resume') {
                    $GetName = ResumeManager::select('uid')->find($item->field);
                    $RequestTitle = HomeController::GetUserData($GetName->uid);
                } elseif ($RequestCenter->field === 'select_ads') {
                    $GetName = EmploymentAdvertisement::select('title')->find($item->field);
                    $RequestTitle = 'برای نیازمندی ' . $GetName->title;
                }

                $RequestReceived[$key]['title'] = $RequestCenter->title . ' ' . $RequestTitle;
                $RequestReceived[$key]['amount'] = $RequestCenter->amount;
            }
        }

        return response()->json($RequestReceived);
    }


    /**
     * Submit Request Received
     * @api /api/request-received-store
     * @Method POST
     * */
    public function RequestReceivedStore(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $RequestCenter = RequestCenter::find($request->id);

        if ($RequestCenter->field !== 'no_field') {
            $ValidData = $request->validate([
                'field' => 'required',
            ], [], [
                'field' => '',
            ]);
        }

        $RequestData = [];
        $RequestData['uid'] = $User;
        $RequestData['request_center_id'] = $request->id;
        $RequestData['field'] = $request->field;
        $RequestData['status'] = 'new';

        if ($RequestReceived = RequestReceived::create($RequestData)) {
            return response()->json(['status' => 200, 'id' => $RequestReceived->id]);
        } else {
            return response()->json(['status' => 'nok']);
        }
    }
}
