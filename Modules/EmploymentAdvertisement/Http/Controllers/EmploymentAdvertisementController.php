<?php

namespace Modules\EmploymentAdvertisement\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementCategory;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementPersonalProficiency;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementProficiency;
use Modules\EmploymentAdvertisement\Http\Requests\EmploymentAdvertisementReuqest;
use Modules\ResumeIntroducer\Entities\ResumeIntroducer;
use Modules\ResumeManager\Entities\ResumeConfirmReject;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\Users\Entities\Users;

class EmploymentAdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $EmploymentAdvertisement = EmploymentAdvertisement::orderBy('created_at', 'desc')->paginate(20);
        return view('employmentadvertisement::advertisement.index', compact('EmploymentAdvertisement'));
    }

    /**
     * Get List API
     * @api /api/get-ads-taxonomy
     * @Method GET
     **/
    public function getTaxonomy()
    {
        $EmploymentAdvertisementCategory = EmploymentAdvertisementCategory::orderBy('title', 'desc')->get()->all();
        $EmploymentAdvertisementProficiency = EmploymentAdvertisementProficiency::orderBy('title', 'desc')->get()->all();
        $EmploymentAdvertisementPersonalProficiency = EmploymentAdvertisementPersonalProficiency::orderBy('title', 'desc')->get()->all();

        $Data = [
            'Category' => $EmploymentAdvertisementCategory,
            'Proficiency' => $EmploymentAdvertisementProficiency,
            'PersonalProficiency' => $EmploymentAdvertisementPersonalProficiency,
        ];

        return response()->json($Data);
    }

    public function ShowOwnerAdvertisement()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $EmploymentAdvertisement = EmploymentAdvertisement::where('uid', auth()->user()->id)->orWhere('uid', Auth::user()->parent_id)->orderBy('created_at', 'desc')
            ->select('id', 'uid', 'title', 'cat', 'head_hunt_recommended', 'expert_ads_recommended', 'updated_at')->get()->all();


        if (count($EmploymentAdvertisement)) {
            $OwnerResume = ResumeIntroducer::where('employment_id', $User)->select('resume_id')->get()->all();
            $RejectResumes = ResumeConfirmReject::where('employer_id', $User)->where('status', 'reject')->get()->all();
            $RejectResumesIDs = [];
            if (count($RejectResumes)) {
                foreach ($RejectResumes as $item) {
                    array_push($RejectResumesIDs, $item->resume_id);
                }
            }
            $OwnerResumesIDs = [];
            if (count($OwnerResume)) {
                foreach ($OwnerResume as $item) {
                    array_push($OwnerResumesIDs, $item->resume_id);
                }
            }

            foreach ($EmploymentAdvertisement as $key => $item) {
                $EmploymentAdvertisement[$key]['recommend_resume_toplicant'] = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->whereNotIn('id', $OwnerResumesIDs ? $OwnerResumesIDs : [])->where('skills', $item->cat)->where('access_resume', 'all')->where('job_status', '!=', 'sold')->where('status', 'accept_job_seeker')->count();
                if (HomeController::GetCompanyCategory($item->cat)) {
                    $EmploymentAdvertisement[$key]['cat_name'] = HomeController::GetCompanyCategory($item->cat)->title;
                } else {
                    $EmploymentAdvertisement[$key]['cat_name'] = 'یافت نشد';
                }
                $EmploymentAdvertisement[$key]['full_name'] = HomeController::GetUserData($item->uid, 'name');
                if ($item->head_hunt_recommended) {
                    $EmploymentAdvertisement[$key]['head_hunt_recommended'] = count(json_decode($item->head_hunt_recommended));
                }
                if ($item->expert_ads_recommended) {
                    $EmploymentAdvertisement[$key]['expert_ads_recommended'] = count(json_decode($item->expert_ads_recommended));
                }
            }
        }

        return response()->json($EmploymentAdvertisement);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employmentadvertisement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    public function store_api(EmploymentAdvertisementReuqest $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $EmploymentAdvertisementData = $request->all();

        $EmploymentAdvertisementData['status'] = 'new';
        $EmploymentAdvertisementData['uid'] = $User;
//        $EmploymentAdvertisementData['personal_proficiency'] = json_encode($request->personal_proficiency);

        if (EmploymentAdvertisement::create($EmploymentAdvertisementData)) {
            return response()->json(['data' => $request->specialty, 'status' => 200]);
        } else {
            return response()->json(['data' => $EmploymentAdvertisementData, 'status' => 401]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('employmentadvertisement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $EmploymentAdvertisement = EmploymentAdvertisement::find($id);
        $EmploymentAdvertisementCategory = EmploymentAdvertisementCategory::get()->all();

        $Data = [
            'EmploymentAdvertisement',
            'EmploymentAdvertisementCategory'
        ];

        return view('employmentadvertisement::advertisement.edit', compact($Data));
    }

    /**
     * Edit Advertisement
     * @api /api/advertisement-edit
     * @Method GET
     **/
    public function EditAdvertisement($id)
    {
        $Advertisement = EmploymentAdvertisement::find($id);
        $EmploymentAdvertisementCategory = EmploymentAdvertisementCategory::orderBy('title', 'desc')->get()->all();
        $EmploymentAdvertisementProficiency = EmploymentAdvertisementProficiency::orderBy('title', 'desc')->get()->all();
        $EmploymentAdvertisementPersonalProficiency = EmploymentAdvertisementPersonalProficiency::orderBy('title', 'desc')->get()->all();

        $Data = [
            'Advertisement' => $Advertisement,
            'Category' => $EmploymentAdvertisementCategory,
            'Proficiency' => $EmploymentAdvertisementProficiency,
            'PersonalProficiency' => $EmploymentAdvertisementPersonalProficiency,
        ];

        return response()->json($Data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $EmploymentAdvertisement = EmploymentAdvertisement::find($id);
        $EmploymentAdvertisementData = $request->all();

        if ($EmploymentAdvertisement->update($EmploymentAdvertisementData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/advertisement')->with('notification', [
                'class' => 'danger',
                'message' => 'بروزرسانی با خطا روبرو شد'
            ]);
        }
    }

    /**
     * Update Advertisement
     * @api /api/advertisement-update
     * @Method POST
     **/
    public function UpdateAdvertisement(EmploymentAdvertisementReuqest $request, $id) {
        $Advertisement = EmploymentAdvertisement::find($id);
        $EmploymentAdvertisementData = [];
        $EmploymentAdvertisementData = $request->all();

        if ($Advertisement->update($EmploymentAdvertisementData)) {
            return response()->json(['data' => $EmploymentAdvertisementData, 'status' => 200]);
        } else {
            return response()->json(['data' => $EmploymentAdvertisementData, 'status' => 401]);
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
            EmploymentAdvertisement::where('id', $key)->delete();
        }

        return redirect('/dashboard/advertisement')->with('notification', [
            'class' => 'success',
            'message' => 'نیازمندی های مورد نظر حذف شد'
        ]);
    }

    public function head_hunt($id)
    {
        $Ads = EmploymentAdvertisement::with('user_tbl')->find($id);
        $Resumes = ResumeManager::where('access_resume', 'all')->where('skills', $Ads->cat)->whereHas('user_tbl', function ($query) use ($Ads) {
            if ($Ads->gender !== 'all') {
                $query->where('gender', '=', $Ads->gender);
            }
        })->paginate(40);
        $AdsCat = EmploymentAdvertisementCategory::find($Ads->cat);

        $Data = [
            'Ads',
            'Resumes',
            'AdsCat',
        ];

        return view('employmentadvertisement::advertisement.headhunt', compact($Data));
    }

    public function expert_ads($id)
    {
        $Ads = EmploymentAdvertisement::find($id);
        $Resumes = ResumeManager::where('skills', $Ads->proficiency)->whereHas('user_tbl', function ($query) use ($Ads) {
            if ($Ads->gender !== 'all') {
                $query->where('gender', '=', $Ads->gender);
            }
        })->paginate(40);
        $AdsProficiency = EmploymentAdvertisementProficiency::find($Ads->proficiency);

        $Data = [
            'Ads',
            'Resumes',
            'AdsProficiency',
        ];

        return view('employmentadvertisement::advertisement.expert_ads', compact($Data));
    }

    public function head_hunt_store(Request $request, $id)
    {
        $Ads = EmploymentAdvertisement::find($id);

        $AdsData['head_hunt_recommended'] = json_encode(array_keys($request->resume));

        if ($Ads->update($AdsData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        }
    }

    public function expert_ads_store(Request $request, $id)
    {
        $Ads = EmploymentAdvertisement::find($id);

        $AdsData['expert_ads_recommended'] = json_encode(array_keys($request->resume));

        if ($Ads->update($AdsData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        }
    }

    /* Get Last Employer Image */
    public function getEmplouerImage($count)
    {
        $Employer = Users::with([
            'avatar_tbl' => function ($query) {
                $query->addSelect('id', 'path', 'file_name', 'extension');
            }
        ])->where('role', 'employer')->where('avatar', '!=', null)->select('id', 'company_name_fa', 'avatar')->get()->take($count);

        foreach ($Employer as $key => $item) {
            if ($item->avatar) :
                if ($item->avatar_tbl->extension != 'svg') {
                    $Employer[$key]['avatar'] = [
                        'path' => url('storage/' . $item->avatar_tbl->path . '126/' . $item->avatar_tbl->file_name),
                        'pathX2' => url('storage/' . $item->avatar_tbl->path . '246/' . $item->avatar_tbl->file_name),
                    ];
                } else {
                    $Employer[$key]['avatar'] = [
                        'path' => url('storage/' . $item->avatar_tbl->path . 'full/' . $item->avatar_tbl->file_name),
                    ];
                }
            endif;
            unset($item->avatar_tbl);
        }

        return response()->json($Employer);
    }
}
