<?php

namespace Modules\SupportSystem\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\FileLibrary\Http\Controllers\FileLibraryController;
use Modules\SupportSystem\Entities\SupportDepartments;
use Modules\SupportSystem\Entities\SupportSystem;
use Modules\SupportSystem\Entities\Ticket;
use Modules\SupportSystem\Http\Requests\SupportSystemPanelRequest;
use Modules\SupportSystem\Http\Requests\SupportSystemRequest;
use Modules\SupportSystem\Http\Requests\TicketReplyRequest;
use Modules\SupportSystem\Http\Requests\TicketRequest;
use Modules\Users\Entities\Users;

class SupportSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $Support = SupportSystem::where('id', 'like', '%' . $_GET['search'] . '%')->orderBy('updated_at', 'desc')->paginate(20);
        } else {
            $Support = SupportSystem::orderBy('updated_at', 'desc')->paginate(20);
        }

        return view('supportsystem::tickets.index', compact('Support'));
    }

    /* Get List API */
    public function getTaxonomy()
    {
        $Departments = SupportDepartments::orderBy('title', 'desc')->get()->all();

        $Data = [
            'Departments' => $Departments,
        ];

        return response()->json($Data);
    }

    public function ShowOwnerTickets(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Support = SupportSystem::where('uid', $User)->where('status', 'like', "%{$request->status}%")->orderBy('updated_at', 'desc')->get()->all();

        if (isset($Support)) {
            foreach ($Support as $key => $item) {
                $Support[$key]['status'] = HomeController::ConvertSupportStatus($item->status);
                $Support[$key]['priority'] = HomeController::ConvertSupportPriority($item->priority);
                $Departeman = SupportDepartments::find($item->department);
                $Support[$key]['departeman_name'] = $Departeman->title;

                if ($item->attachments) {
                    $AttachmentsItems = [];
                    foreach (json_decode($item->attachments, true) as $key2 => $itemAttachment) {
                        $AttachmentsData = FileLibrary::find($itemAttachment);
                        array_push($AttachmentsItems, $AttachmentsData);
                        $Support[$key]['attachments_data'] = $AttachmentsItems;
                    }
                }
            }
        }
        return response()->json($Support);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $SupportDepartments = SupportDepartments::orderBy('title', 'desc')->get()->all();
        $Users = Users::get()->all();

        $Data = [
            'SupportDepartments',
            'Users'
        ];

        return view('supportsystem::tickets.create', compact($Data));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(SupportSystemRequest $request)
    {
        $SupportSystemData = $request->all();
        $SupportSystemData['uid'] = $request->uid;

        /* Store Attachments */
        if (!empty($request->file('attachments'))) {
            $SupportSystemData['attachments'] = [];
            foreach ($request->file('attachments') as $item) {
                array_push($SupportSystemData['attachments'], FileLibraryController::upload($item, 'file', 'support/files', 'support'));
            }
            $SupportSystemData['attachments'] = json_encode($SupportSystemData['attachments']);
        }

        if (SupportSystem::create($SupportSystemData)) {
            return redirect('dashboard/support')->with('notification', [
                'class' => 'success',
                'message' => 'تیکت با موفقیت ایحاد شد.'
            ]);
        } else {
            return redirect()->back()->with('notification', [
                'class' => 'alert',
                'message' => 'ذخیره اطلاعات با مشکل روبرو شد.'
            ]);
        }
    }

    public function store_support(SupportSystemPanelRequest $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }
        $SupportSystemData = $request->all();
        $SupportSystemData['uid'] = $User;
        $SupportSystemData['created_by'] = $User;
        $SupportSystemData['status'] = 'pending';

        /* Store Attachments */
        if (!empty($request->file('attachments'))) {
            $SupportSystemData['attachments'] = [];
            $File = FileLibraryController::upload($request->file('attachments'), 'file', 'support/files', 'support');
            array_push($SupportSystemData['attachments'], $File);
//            $SupportSystemData['attachments'] = [];
//            foreach ($request->file('attachments') as $item) {
//                array_push($SupportSystemData['attachments'], FileLibraryController::upload($item, 'file', 'support/files', 'support'));
//            }
            $SupportSystemData['attachments'] = json_encode($SupportSystemData['attachments']);
        }


        if (SupportSystem::create($SupportSystemData)) {
            return response()->json(['data' => $SupportSystemData, 'status' => 200]);
        } else {
            return response()->json(['data' => $SupportSystemData, 'status' => 500]);
        }
    }

    public function TicketReply(TicketReplyRequest $request, $id)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $TicketData = $request->all();
        $TicketData['support_id'] = $id;
        $TicketData['uid'] = $User;

        /* Store Attachments */
        if (!empty($request->file('attachments'))) {
            $TicketData['attachments'] = [];
            foreach ($request->file('attachments') as $item) {
                array_push($TicketData['attachments'], FileLibraryController::upload($item, 'file', 'support/files', 'support'));
            }
            $TicketData['attachments'] = json_encode($TicketData['attachments']);
        }

        if (Ticket::create($TicketData)) {
            return response()->json(['data' => $TicketData, 'status' => 200]);
        } else {
            return response()->json(['data' => $TicketData, 'status' => 500]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $Support = SupportSystem::where('id', $id)
            ->select('id', 'title', 'ticket_content', 'department', 'priority', 'status', 'created_at', 'updated_at')->with('department_tbl')->first();

        $Tickets = Ticket::where('support_id', $Support->id)->orderBy('created_at', 'desc')->get();

        $Support['status'] = HomeController::ConvertSupportStatus($Support->status);
        $Support['department'] = $Support->department_tbl->title;
        $Support['priority'] = HomeController::ConvertSupportPriority($Support->priority);
        $Support['tickets'] = $Tickets;

        $TicketsComplete = [];
        $TicketsExperts = [];
        /* Fetch Tickets */
        foreach ($Support['tickets'] as $key => $item) {
            $TicketsComplete[$key] = [
                'id' => $item->id,
                'name' => HomeController::GetUserData($item->uid),
                'avatar' => HomeController::GetAvatar('35', '70', HomeController::GetUserData($item->uid, 'avatar')),
                'replay_text' => $item->replay_text,
                'attachments' => $item->attachments,
                'created_at' => $item->created_at,
            ];

            $Role = HomeController::GetUserData($item->uid, 'role');

            if ($Role !== 'employer' && $Role !== 'job_seeker' && $Role !== 'user') {
                array_push($TicketsExperts, $item->uid);
            }
        }

        $Support['tickets'] = $TicketsComplete;
        $Support['experts'] = array_unique($TicketsExperts);
        $Support['experts'] = array_values($Support['experts']);

        /* Fetch Experts */
        $TicketsExperts = [];
        foreach ($Support['experts'] as $key => $item) {
            $TicketsExperts[$key] = [
                'id' => $item,
                'name' => HomeController::GetUserData($item),
                'avatar' => HomeController::GetAvatar('35', '70', HomeController::GetUserData($item, 'avatar')),
            ];
        }

        $Support['experts'] = $TicketsExperts;

        unset($Support['department_tbl']);

        return response()->json($Support);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Support = SupportSystem::find($id);
        $SupportDepartments = SupportDepartments::get()->all();
        $Users = Users::get()->all();

        $Attachments = [];

        if ($Support->attachments) {
            if (count(json_decode($Support->attachments))) {
                foreach (json_decode($Support->attachments) as $item) {
                    $Attachment = FileLibrary::find($item);

                    array_push($Attachments,
                        [
                            'id' => $Attachment->id,
                            'name' => $Attachment->org_name,
                            'path' => 'storage/' . $Attachment->path . $Attachment->file_name,
                        ]);
                }
            }
        }

        $Data = [
            'Support',
            'SupportDepartments',
            'Users',
            'Attachments',
        ];

        return view('supportsystem::tickets.edit', compact($Data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(SupportSystemRequest $request, $id)
    {
        $SupportSystem = SupportSystem::find($id);

        $SupportSystemData = $request->all();
        $SupportSystemData['uid'] = $request->uid;

        $SupportSystemData['attachments'] = [];

        if (!empty($request->current_attachment)) {
            $SupportSystemData['attachments'] = $request->current_attachment;
        }

        /* Store Attachments */
        if (!empty($request->file('attachments'))) {
            foreach ($request->file('attachments') as $item) {
                array_push($SupportSystemData['attachments'], FileLibraryController::upload($item, 'file', 'support/files', 'support'));
            }
            $SupportSystemData['attachments'] = json_encode($SupportSystemData['attachments']);
        }

        if ($SupportSystem->update($SupportSystemData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/support')->with('notification', [
                'class' => 'danger',
                'message' => 'بروزرسانی با خطا روبرو شد'
            ]);
        }
    }

    public function tickets($id)
    {
        $Support = SupportSystem::find($id);
        $Tickets = Ticket::where('support_id', $id)->orderBy('updated_at', 'desc')->get()->all();
        $Attachments = [];

        if ($Support->attachments) {
            if (count(json_decode($Support->attachments))) {
                foreach (json_decode($Support->attachments) as $item) {
                    $Attachment = FileLibrary::find($item);

                    array_push($Attachments,
                        [
                            'id' => $Attachment->id,
                            'name' => $Attachment->org_name,
                            'path' => 'storage/' . $Attachment->path . $Attachment->file_name,
                        ]);
                }
            }
        }

        $Data = [
            'Support',
            'Tickets',
            'Attachments',
        ];

        return view('supportsystem::tickets.tickets', compact($Data));
    }

    public function tickets_store(TicketRequest $request, $id)
    {
        $Support = SupportSystem::find($id);
        $TicketData = $request->all();
        $TicketData['support_id'] = $id;
        $TicketData['uid'] = auth()->user()->id;

        /* Store Attachments */
        if (!empty($request->file('attachments'))) {
            $TicketData['attachments'] = [];
            foreach ($request->file('attachments') as $item) {
                array_push($TicketData['attachments'], FileLibraryController::upload($item, 'file', 'support/files', 'support'));
            }
            $TicketData['attachments'] = json_encode($TicketData['attachments']);
        }

        if (Ticket::create($TicketData)) {
            $Support->update(['status' => 'replied']);
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        foreach ($request->delete_item as $key => $item) {
            $Ticket = Ticket::where('support_id', $key)->get()->all();
            foreach ($Ticket as $item_ticket) {
                Ticket::find($item_ticket->id)->delete();
            }
            SupportSystem::where('id', $key)->delete();
        }

        return redirect()->back()->with('notification', [
            'class' => 'success',
            'message' => 'تیکت های مورد نظر حذف شد'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy_ticket($id)
    {
        Ticket::find($id)->delete();
        return redirect()->back()->with('notification', [
            'class' => 'success',
            'message' => 'تیکت مورد نظر حذف شد'
        ]);
    }
}
