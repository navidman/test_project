<?php

namespace Modules\RequestCenter\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\RequestCenter\Entities\RequestCenter;
use Modules\RequestCenter\Http\Requests\RequestCenterRequest;
use Modules\ResumeManager\Entities\PurchasedResumes;
use Modules\ResumeManager\Entities\ResumeManager;

class RequestCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $RequestCenter = RequestCenter::where('id', 'like', '%' . $_GET['search'] . '%')->orderBy('updated_at', 'desc')->paginate(20);
        } else {
            $RequestCenter = RequestCenter::orderBy('updated_at', 'desc')->paginate(20);
        }

        return view('requestcenter::request-center.index', compact('RequestCenter'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('requestcenter::request-center.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(RequestCenterRequest $request)
    {
        $User = auth()->user();
        $RequestCenterData = $request->all();
        $RequestCenterData['uid'] = $User->id;

        if (RequestCenter::create($RequestCenterData)) {
            return redirect('dashboard/request-center')->with('notification', [
                'class' => 'success',
                'message' => 'منبع درخواست با موفقیت ثبت شد.'
            ]);
        } else {
            return redirect()->back()->with('notification', [
                'class' => 'alert',
                'message' => 'ذخیره اطلاعات با مشکل روبرو شد.'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $RequestCenter = RequestCenter::find($id);
        return view('requestcenter::request-center.edit', compact('RequestCenter'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(RequestCenterRequest $request, $id)
    {
        $RequestCenter = RequestCenter::find($id);
        $RequestCenterData = $request->all();

        if ($RequestCenter->update($RequestCenterData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/request-center')->with('notification', [
                'class' => 'danger',
                'message' => 'بروزرسانی با خطا روبرو شد'
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
            RequestCenter::where('id', $key)->delete();
        }

        return redirect('/dashboard/request-center')->with('notification', [
            'class' => 'success',
            'message' => 'منبع درخواست های مورد نظر حذف شد'
        ]);

    }

    /**
     * Get Request Center List
     * @api /api/request-center
     * @Method GET
     **/
    public function request_list()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $RequestCenter = RequestCenter::get()->all();

        $Resume = [];
        $PurchasedResumes = PurchasedResumes::where('buyer_id', $User)->select('resume_id')->get()->all();
        $PurchasedResumesIDs = [];

        if (count($PurchasedResumes)) {
            foreach ($PurchasedResumes as $item) {
                array_push($PurchasedResumesIDs, $item->resume_id);
            }
        }

        $Resume = ResumeManager::whereIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])
            ->orderBy('created_at', 'desc')->where('status', 'accept_job_seeker')
            ->select('id', 'uid')->get();

        if (count($Resume)) {
            foreach ($Resume as $key => $item) {
                $Resume[$key]['full_name'] = HomeController::GetUserData($item->uid);
            }
        }

        $EmploymentAdvertisement = EmploymentAdvertisement::where('uid', $User)->orderBy('created_at', 'desc')
            ->select('id', 'uid', 'title')->get()->all();

        return response()->json(['RequestCenter' => $RequestCenter, 'Resume' => $Resume, 'EmploymentAdvertisement' => $EmploymentAdvertisement]);
    }
}
