<?php

namespace Modules\RequestCenter\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\FileLibrary\Http\Controllers\FileLibraryController;
use Modules\RequestCenter\Entities\RequestCenter;
use Modules\RequestCenter\Entities\RequestReceived;
use Modules\RequestCenter\Entities\RequestReplies;
use Modules\RequestCenter\Http\Requests\RequestRepliesRequest;
use Modules\ResumeManager\Entities\ResumeManager;

class RequestRepliesController extends Controller
{
    /**
     * Show Request Received
     * @api /request-received/show/{id}
     * @Method GET
     * */
    public function ShowRequestReceivedAdmin($id)
    {

        $RequestReceived = RequestReceived::where('id', $id)->first();

        if ($RequestReceived) {
            $RequestCenter = RequestCenter::find($RequestReceived->request_center_id);
            $RequestTitle = '';
            if ($RequestCenter->field === 'select_resume') {
                if ($RequestReceived->field === 'all') {
                    $RequestTitle = 'تمام رزومه ها';
                } else {
                    $GetName = ResumeManager::select('uid')->find($RequestReceived->field);
                    $RequestTitle = HomeController::GetUserData($GetName->uid);
                }
            } elseif ($RequestCenter->field === 'select_ads') {
                if ($RequestReceived->field === 'all') {
                    $RequestTitle = 'برای تمام نیازمندی ها';
                } else {
                    $GetName = EmploymentAdvertisement::select('title')->find($RequestReceived->field);
                    $RequestTitle = 'برای نیازمندی ' . $GetName->title;
                }
            }

            $RequestReceived['title'] = $RequestCenter->title . ' ' . $RequestTitle;
            $RequestReceived['avatar'] = HomeController::GetAvatar('35', '70', HomeController::GetUserData($RequestReceived->uid, 'avatar'));
            $RequestReceived['full_name'] = HomeController::GetUserData($RequestReceived->uid);
            $RequestReceived['role'] = HomeController::GetUserData($RequestReceived->uid, 'role') === 'employer' ? 'کارفرما' : 'کارشناس تاپلیکنت';

            $RequestReplies = RequestReplies::where('request_id', $RequestReceived->id)->orderBy('created_at', 'desc')->get();

            foreach ($RequestReplies as $key => $item) {
                $RequestReplies[$key]['full_name'] = HomeController::GetUserData($item->uid);
                $RequestReplies[$key]['avatar'] = HomeController::GetAvatar('35', '70', HomeController::GetUserData($item->uid, 'avatar'));
                if ($item->attachments) {
                    $Attachments = FileLibrary::find($item->attachments);
                    $RequestReplies[$key]['attachments_path'] = url('storage/' . $Attachments->path . '/' . $Attachments->file_name);
                }

                if ($item->voice) {
                    $VoiceFile = FileLibrary::find($item->voice);
                    $RequestReplies[$key]['voice_path'] = url('storage/' . $VoiceFile->path . '/' . $VoiceFile->file_name);
                }
            }

            $Data = [
                'RequestReceived',
                'RequestReplies',
            ];
            return view('requestcenter::request-replies.replies', compact($Data));
        } else {
        }
    }

    /**
     * Submit Reply Admin
     * @api /request-replies/store/{id}
     * @Method POST
     **/
    public function SubmitRepliesAdmin(RequestRepliesRequest $request)
    {
        $User = auth()->user()->id;

        $RequestReceived = RequestReceived::select('id', 'uid')->find($request->id);

        if ($RequestReceived) {
            $RequestRepliesData = [];
            $RequestRepliesData['uid'] = $User;
            $RequestRepliesData['request_id'] = $request->id;
            $RequestRepliesData['content_text'] = $request->content_text;
            if ($request->file('attachments')) {
                $RequestRepliesData['attachments'] = FileLibraryController::upload($request->file('attachments'), 'file', 'request/attachments', 'request');
            }
            if ($request->file('voice')) {
                $RequestRepliesData['voice'] = FileLibraryController::upload($request->file('voice'), 'file', 'request/voice', 'request');
            }

            if (RequestReplies::create($RequestRepliesData)) {
                $RequestReceived->update(['status' => 'pending']);

                return redirect()->back()->with('notification', [
                    'class' => 'success',
                    'message' => 'پاسخ ارسال شد'
                ]);
            } else {
                return redirect()->back()->with('notification', [
                    'class' => 'danger',
                    'message' => 'ارسال پاسخ با خطا روبرو شد'
                ]);
            }
        }
    }

    /**
     * Show Request Received
     * @api /api/request-received/:id
     * @Method GET
     **/
    public function ShowRequestReceived($id)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $RequestReceived = RequestReceived::where('id', $id)->where('uid', $User)->first();

        if ($RequestReceived) {
            $RequestCenter = RequestCenter::find($RequestReceived->request_center_id);
            $RequestTitle = '';
            if ($RequestCenter->field === 'select_resume') {
                $GetName = ResumeManager::select('uid')->find($RequestReceived->field);
                $RequestTitle = HomeController::GetUserData($GetName->uid);
            } elseif ($RequestCenter->field === 'select_ads') {
                $GetName = EmploymentAdvertisement::select('title')->find($RequestReceived->field);
                $RequestTitle = 'برای نیازمندی ' . $GetName->title;
            }

            $RequestReceived['title'] = $RequestCenter->title . ' ' . $RequestTitle;
            $RequestReceived['avatar'] = HomeController::GetAvatar('35', '70', HomeController::GetUserData($RequestReceived->uid, 'avatar'));
            $RequestReceived['full_name'] = HomeController::GetUserData($RequestReceived->uid);
            $RequestReceived['role'] = HomeController::GetUserData($RequestReceived->uid, 'role') === 'employer' ? 'کارفرما' : 'کارشناس تاپلیکنت';

            $RequestReplies = RequestReplies::where('request_id', $RequestReceived->id)->orderBy('created_at', 'desc')->get();

            foreach ($RequestReplies as $key => $item) {
                $RequestReplies[$key]['full_name'] = HomeController::GetUserData($item->uid);
                $RequestReplies[$key]['avatar'] = HomeController::GetAvatar('35', '70', HomeController::GetUserData($item->uid, 'avatar'));
                $RequestReplies[$key]['role'] = HomeController::GetUserData($item->uid, 'role') === 'employer' ? '' : 'کارشناس تاپلیکنت';
                if ($item->attachments) {
                    $Attachments = FileLibrary::find($item->attachments);
                    $RequestReplies[$key]['attachments_path'] = url('storage/' . $Attachments->path . '/' . $Attachments->file_name);
                }

                if ($item->voice) {
                    $VoiceFile = FileLibrary::find($item->voice);
                    $RequestReplies[$key]['voice_path'] = url('storage/' . $VoiceFile->path . '/' . $VoiceFile->file_name);
                }
            }

            return response()->json(['status' => 200, 'RequestReceived' => $RequestReceived, 'RequestReplies' => $RequestReplies]);
        } else {
            return response()->json(['status' => 404]);
        }
    }

    /**
     * Submit Reply
     * @api /api/request-replies
     * @Method POST
     **/
    public function SubmitReplies(RequestRepliesRequest $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $RequestReceived = RequestReceived::where('uid', $User)->where('id', $request->id)->select('id', 'uid')->first();

        if ($RequestReceived) {
            $RequestRepliesData = [];
            $RequestRepliesData['uid'] = $User;
            $RequestRepliesData['request_id'] = $request->id;
            $RequestRepliesData['content_text'] = $request->content_text;
            if ($request->file('attachments')) {
                $RequestRepliesData['attachments'] = FileLibraryController::upload($request->file('attachments'), 'file', 'request/attachments', 'request');
            }
            if ($request->file('voice')) {
                $RequestRepliesData['voice'] = FileLibraryController::upload($request->file('voice'), 'file', 'request/voice', 'request');
            }

            if (RequestReplies::create($RequestRepliesData)) {
                $RequestReceived->update(['status' => 'replied']);

                return response()->json(['status' => 200]);
            } else {
                return response()->json(['status' => 'nok']);
            }
        } else {
            return response()->json(['status' => 404]);
        }
    }
}
