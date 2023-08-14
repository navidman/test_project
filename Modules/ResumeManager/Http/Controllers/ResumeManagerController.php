<?php

namespace Modules\ResumeManager\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementCategory;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementPersonalProficiency;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementProficiency;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\FileLibrary\Http\Controllers\FileLibraryController;
use Modules\OrderManagement\Entities\OrderManagement;
use Modules\PartnerCompanies\Entities\PartnerCompanies;
use Modules\Payments\Entities\Wallet;
use Modules\ResumeIntroducer\Entities\ResumeIntroducer;
use Modules\ResumeManager\Entities\PurchasedResumes;
use Modules\ResumeManager\Entities\ResumeConfirmReject;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\ResumeManager\Entities\WorkExperience;
use Modules\ResumeManager\Http\Requests\ResumeManagerRequest;
use Modules\ResumeManager\Http\Requests\ResumeManagerSuperAdminRequest;
use Modules\ResumeManager\Http\Requests\UpdateMyResumeRequest;
use Modules\SmsHandler\Http\Controllers\SmsHandlerController;
use Modules\Users\Entities\Users;

class ResumeManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $Resumes = ResumeManager::with(['user_tbl.avatar'])->orderBy('created_at', 'desc')->paginate(20);

        return view('resumemanager::index', compact('Resumes'));
    }

    public function ShowRecommendedResume()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }
        $PurchasedResumes = PurchasedResumes::where('buyer_id', $User)->select('resume_id')->orderBy('created_at', 'desc')->get()->all();
        $RejectResumes = ResumeConfirmReject::where('employer_id', $User)->where('status', 'reject')->get()->all();
        $ConfirmResumes = ResumeConfirmReject::where('employer_id', $User)->where('status', 'confirm')->get()->all();
        $OwnerResume = ResumeIntroducer::where('employment_id', $User)->select('resume_id')->get()->all();
        $PurchasedResumesIDs = [];
        $OwnerResumesIDs = [];
        $RejectResumesIDs = [];
        $ConfirmResumesIDs = [];
        $Resume = [];

        if (count($PurchasedResumes)) {
            foreach ($PurchasedResumes as $item) {
                array_push($PurchasedResumesIDs, $item->resume_id);
            }
        }

        if (count($ConfirmResumes)) {
            foreach ($ConfirmResumes as $item) {
                array_push($ConfirmResumesIDs, $item->resume_id);
            }
        }

        if (count($RejectResumes)) {
            foreach ($RejectResumes as $item) {
                array_push($RejectResumesIDs, $item->resume_id);
            }
        }

        if (count($OwnerResume)) {
            foreach ($OwnerResume as $item) {
                array_push($OwnerResumesIDs, $item->resume_id);
            }
        }

        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'confirmed') {
                $Resume = ResumeManager::whereIn('id', $ConfirmResumesIDs ? $ConfirmResumesIDs : [])->whereNotIn('id', $OwnerResumesIDs ? $OwnerResumesIDs : [])->whereNotIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->where('access_resume', 'all')->where('job_status', '!=', 'sold')->orderBy('created_at', 'desc')->where('status', 'accept_job_seeker')
                    ->select('id', 'uid', 'skills', 'created_at', 'updated_at')->get();
            }
//            if ($_GET['status'] == 'purchased') {
//                $Resume = ResumeManager::whereIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->orderBy('created_at', 'desc')->where('status', 'accept_job_seeker')
//                    ->select('id', 'uid', 'skills', 'job_status', 'created_at', 'updated_at')->get();
//            }
            if ($_GET['status'] == 'purchased') {
                $idsOrdered = $PurchasedResumesIDs ? implode(',', $PurchasedResumesIDs) : 'null';
                $Resume = ResumeManager::whereIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->orderByRaw("FIELD(id, $idsOrdered)")
                    ->where('status', 'accept_job_seeker')
                    ->select('id', 'uid', 'level', 'skills', 'job_status', 'resume_file', 'confirm_date', 'created_at', 'updated_at')->get();

                foreach ($Resume as $key => $item) {
                    $Resume[$key]['job_status'] = 'sold';
                }
            }
        }

        if (isset($_GET['other_recommended'])) {
            if (isset($_GET['other_recommended'])) {
                $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->whereNotIn('id', $OwnerResumesIDs ? $OwnerResumesIDs : [])->whereNotIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->where('access_resume', 'all')->where('job_status', '!=', 'sold')->orderBy('created_at', 'desc')->where('status', 'accept_job_seeker')
                    ->select('id', 'uid', 'skills', 'created_at', 'updated_at')->get();
            }
        }

        if (isset($_GET['partner_recommended'])) {
            $Resume = [];
            $PartnerCompany = PartnerCompanies::whereNotIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->where('from_id', $User)->orWhere('to_id', $User)->where('status', 'accept')->where('active', 'true')->get()->all();
            $PartnerCompanyIDs = [];
            $PartnerIntroducerIDs = [];
            if (count($PartnerCompany)) {
                foreach ($PartnerCompany as $item) {
                    array_push($PartnerCompanyIDs, $item->to_id);
                    array_push($PartnerCompanyIDs, $item->from_id);
                }

                $PartnerCompanyIDs = array_unique($PartnerCompanyIDs);

                if (($key = array_search($User, $PartnerCompanyIDs)) !== false) {
                    unset($PartnerCompanyIDs[$key]);
                }

                $PartnerResume = ResumeIntroducer::whereIn('employment_id', $PartnerCompanyIDs ? $PartnerCompanyIDs : [])->get()->all();

                foreach ($PartnerResume as $item) {
                    array_push($PartnerIntroducerIDs, $item->resume_id);
                }

                $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->whereIn('id', $PartnerIntroducerIDs ? $PartnerIntroducerIDs : [])->where('access_resume', 'cooperation_companies')->where('job_status', '!=', 'sold')->orderBy('created_at', 'desc')->where('status', 'accept_job_seeker')
                    ->select('id', 'uid', 'skills', 'created_at', 'updated_at')->get();
            }
        }

        if (isset($_GET['headHunt']) && $_GET['headHunt'] == 'true') {
            $Ads = EmploymentAdvertisement::find($_GET['AdsID']);
            $HeadHuntRecommended = json_decode($Ads->head_hunt_recommended);
            $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->whereNotIn('id', $OwnerResumesIDs ? $OwnerResumesIDs : [])->whereNotIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->whereIn('id', $HeadHuntRecommended ? $HeadHuntRecommended : [])->where('access_resume', 'all')->where('job_status', '!=', 'sold')->where('status', 'accept_job_seeker')->orderBy('created_at', 'desc')
                ->select('id', 'uid', 'skills', 'created_at', 'updated_at')->get();
        } elseif (isset($_GET['expertAds']) && $_GET['expertAds'] == 'true') {
            $Ads = EmploymentAdvertisement::find($_GET['AdsID']);
            $ExpertRecommended = json_decode($Ads->expert_ads_recommended);
            $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->whereNotIn('id', $OwnerResumesIDs ? $OwnerResumesIDs : [])->whereNotIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->whereIn('id', $ExpertRecommended ? $ExpertRecommended : [])->where('access_resume', 'all')->where('job_status', '!=', 'sold')->orderBy('created_at', 'desc')->where('status', 'accept_job_seeker')
                ->select('id', 'uid', 'skills', 'created_at', 'updated_at')->get();
        } elseif (isset($_GET['proficiencyID'])) {
            $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->whereNotIn('id', $OwnerResumesIDs ? $OwnerResumesIDs : [])->whereNotIn('id', $PurchasedResumesIDs ? $PurchasedResumesIDs : [])->where('access_resume', 'all')->where('job_status', '!=', 'sold')->orderBy('created_at', 'desc')->where('status', 'accept_job_seeker')->where('skills', $_GET['proficiencyID'])
                ->select('id', 'uid', 'skills', 'created_at', 'updated_at')->get();
        }

        if (count($Resume)) {
            foreach ($Resume as $key => $item) {
                $CheckResumePurchased = false;
                if ($item->job_status && $item->job_status === 'sold') {
                    if ($PurchaseResult = PurchasedResumes::where('buyer_id', $User)->where('resume_id', $item->id)->select('result', 'reasons', 'amount')->first()) {
                        $PurchaseDate = PurchasedResumes::where('resume_id', $item->id)->where('buyer_id', $User)->select('created_at')->first();
//                        $Resume[$key]['expire'] = HomeController::ConvertDate($item->confirm_date, 'day');
                        $Resume[$key]['expire'] = HomeController::ConvertDate($PurchaseDate->created_at, 'day') <= 30 ? 30 - HomeController::ConvertDate($PurchaseDate->created_at, 'day') : '0';
                        $ResumeFile = FileLibrary::find($item->resume_file);
                        $CheckResumePurchased = true;
                        if ($ResumeFile) {
                            $Resume[$key]['resume_file'] = url('storage/' . $ResumeFile->path . '/' . $ResumeFile->file_name);
                        } else {
                            $Resume[$key]['resume_file'] = '';
                        }
                        $Resume[$key]['purchase_result'] = $PurchaseResult->result;

                        if ($PurchaseResult->result) {
                            $CostPercentage = 0;

                            if ($PurchaseResult->result === 'hired') {
                                $CostPercentage = 5;
                            } elseif ($PurchaseResult->result === 'not_hired') {
                                $CostPercentage = 70;
                            }

//                            $Resume[$key]['topli_cost'] = HomeController::CalculateTopliByLevel($item->level, $CostPercentage);
                            $Resume[$key]['topli_cost'] = ($CostPercentage / 100) * $PurchaseResult->amount;
                        } else {
                            /*Discount */
//                            $Resume[$key]['topli_cost'] = HomeController::CalculateTopliByLevel($item->level, 70);
                            $Resume[$key]['topli_cost'] = (70 / 100) * $PurchaseResult->amount;
                        }
                        if ($PurchaseResult->reasons) {
                            $Resume[$key]['reasons'] = true;
                        } else {
                            $Resume[$key]['reasons'] = false;
                        }
                    }
                }
                $Resume[$key]['full_name'] = $CheckResumePurchased ? HomeController::GetUserData($item->uid, 'name') : HomeController::Censor(HomeController::GetUserData($item->uid, 'name'));
                $Resume[$key]['confidence'] = HomeController::CheckConfidence($item->id);
                $Resume[$key]['skills'] = HomeController::GetCompanyCategory($item->skills) ? HomeController::GetCompanyCategory($item->skills)->title : 'مشخص نشده است';
                $Resume[$key]['avatar'] = $CheckResumePurchased ? HomeController::GetAvatar('46', '92', $item->user_tbl->avatar) : HomeController::AvatarGenerate(HomeController::GetUserData($item->uid, 'gender_org'));
                $Resume[$key]['confirmed'] = HomeController::CheckResumeConfirmed($item->id);
                $Resume[$key]['percentage'] = HomeController::CheckResumePercentage($item->id);
            }
        }

        return response()->json($Resume);
    }

    public function ShowOwnerResume()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }
        if (isset($_GET['status'])) {
            $ResumeIntroducer = ResumeIntroducer::with(['resume_tbl', 'resume_tbl.user_tbl'])
                ->whereHas('resume_tbl', function ($query) {
                    if ($_GET['status'] == 'pending') {
                        $query->where('status', 'pending_operator');
                        $query->orWhere('status', 'pending_job_seeker');
                    }
                })->whereHas('resume_tbl', function ($query) {
                    if ($_GET['status'] == 'accepted') {
                        $query->where('status', 'accept_job_seeker');
                    }
                })->whereHas('resume_tbl', function ($query) {
                    if ($_GET['status'] == 'reject') {
                        $query->where('status', 'toplicant_reject');
                        $query->orWhere('status', 'job_seeker_reject');
                    }
                })->where(
                    function ($query) {
                        if ($_GET['status'] == 'expire') {
                            $query->where('created_at', '<', Carbon::today()->subDays(60));
                        }
                    }
                )->where('employment_id', $User)
                ->select('id', 'resume_id', 'employment_id')->get()->all();

            if ($ResumeIntroducer) {
                foreach ($ResumeIntroducer as $key => $item) {
                    $ResumeIntroducer[$key]['full_name'] = $item->resume_tbl->user_tbl->full_name;
                    $ResumeIntroducer[$key]['avatar'] = HomeController::GetAvatar('46', '92', $item->resume_tbl->user_tbl->avatar);
                    $ResumeIntroducer[$key]['job_position'] = $item->resume_tbl->job_position;
                    $ResumeIntroducer[$key]['status'] = $item->resume_tbl->status;
                    $ResumeIntroducer[$key]['percentage'] = HomeController::CheckResumePercentage($item->resume_tbl->id);
                    unset($item['resume_tbl']);
                }
            }

        }


        return response()->json($ResumeIntroducer);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public
    function store(ResumeManagerRequest $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $CheckUserExists = Users::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        /* JobSeeker Check of EmploymentID  */
        if ($CheckUserExists) {
            if ($CheckUserExists->role == 'employer') {
                return response()->json(['status' => 301]);
            }

            $OwnerJobSeekerExistCheck = ResumeIntroducer::where('job_seeker_id', $CheckUserExists->id)->where('employment_id', $User)->first();
            if ($OwnerJobSeekerExistCheck) {
                return response()->json(['status' => 301]);
            }
        }

        /* Resume Data */
        $ResumeData = $request->all();
        $ResumeData['status'] = 'pending_operator';
//        $ResumeData['specialty'] = json_encode(explode(',', $request->specialty));
        if ($request->file('resume_file')) {
            $ResumeData['resume_file'] = FileLibraryController::upload($request->file('resume_file'), 'file', 'resume/cv', 'resume');
        }

        /* User Data */
        $Userdata['full_name'] = $request->full_name;
        $Userdata['email'] = $request->email;
        $Userdata['phone'] = $request->phone;
        $Userdata['job_position'] = $request->job_position;
        $Userdata['province'] = $request->province;
        $Userdata['city'] = $request->city;
        $Userdata['district'] = $request->district;
        $Userdata['gender'] = $request->gender;
        $Userdata['role'] = 'job_seeker';
        $Password = rand(100000000, 99999999);
        $Userdata['password'] = Hash::make($Password);
        if ($request->file('avatar')) {
            $Userdata['avatar'] = FileLibraryController::upload($request->file('avatar'), 'image', 'users/avatar', 'users', array([35, 35, 'fit'], [46, 46, 'fit'], [63, 63, 'fit'], [70, 70, 'fit'], [92, 92, 'fit'], [126, 126, 'fit'], [246, 246, 'fit'], [600, 600, 'fit']));
        }

        /* Resume Introducer */
        $ResumeIntroducer = $request->all();
        $ResumeIntroducer['employment_id'] = $User;
        $ResumeIntroducer['status'] = 'active';
        if ($request->file('interview_file')) {
            $ResumeIntroducer['interview_file'] = FileLibraryController::upload($request->file('interview_file'), 'file', 'resume/interview', 'resume');
        }
        if ($request->file('voice')) {
            $ResumeIntroducer['voice'] = FileLibraryController::upload($request->file('voice'), 'file', 'resume/voice', 'resume');
        }

        $CheckUserExists = Users::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        if ($CheckUserExists) {
            $ResumeData['uid'] = $CheckUserExists->id;
            if ($Resume = ResumeManager::create($ResumeData)) {
                $ResumeIntroducer['job_seeker_id'] = $CheckUserExists->id;
                $ResumeIntroducer['resume_id'] = $Resume->id;
                ResumeIntroducer::create($ResumeIntroducer);

                return response()->json(['status' => 200]);
            }
        } else {
            if ($user = Users::create($Userdata)) {
                $ResumeData['uid'] = $user->id;
                if ($Resume = ResumeManager::create($ResumeData)) {
                    $ResumeIntroducer['job_seeker_id'] = $user->id;
                    $ResumeIntroducer['resume_id'] = $Resume->id;
                    ResumeIntroducer::create($ResumeIntroducer);

                    return response()->json(['status' => 200]);
                }
            } else {
                return response()->json(['data' => $ResumeData, 'status' => 401]);
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public
    function show($id)
    {
        $HasBuyer = 0;
        $User = null;
        $ResumeSelectView = ['id', 'uid', 'birth_day', 'sarbazi', 'skills', 'level', 'cooperation_type', 'job_position', 'salary', 'job_status', 'presence_type', 'experience', 'updated_at'];
        $ResumeIntroducerSelectView = ['id', 'confidence', 'employment_id', 'recognition', 'expertise', 'personality', 'experience', 'software', 'organizational_behavior', 'passion', 'salary_rate', 'reason_adjustment', 'expert_opinion', 'comment_employment', 'confidence'];
        $UserSelectView = ['id', 'full_name', 'province', 'district', 'city', 'gender'];
        $RejectResumesIDs = [];

        if (auth('sanctum')->check()) {
            if (auth('sanctum')->user()->parent_id) {
                $User = Auth::user()->parent_id;
            } else {
                $User = auth('sanctum')->user()->id;
            }

            $RejectResumes = ResumeConfirmReject::where('employer_id', $User)->where('status', 'reject')->get()->all();
            $ConfirmResumes = ResumeConfirmReject::where('employer_id', $User)->where('status', 'confirm')->get()->all();

            if (count($RejectResumes)) {
                foreach ($RejectResumes as $item) {
                    array_push($RejectResumesIDs, $item->resume_id);
                }
            }

            if (PurchasedResumes::where('resume_id', $id)->where('buyer_id', $User)->count() || ResumeIntroducer::where('resume_id', $id)->where('employment_id', $User)->count() || ResumeManager::where('id', $id)->where('uid', $User)->count()) {
                $HasBuyer = 1;
                array_push($ResumeSelectView, 'resume_file', 'dribbble', 'linkedin');
                array_push($ResumeIntroducerSelectView, 'interview_file', 'voice');
                array_push($UserSelectView, 'email', 'phone');
            }
        }

        $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->where('status', 'accept_job_seeker')->with(
            [
                'user_tbl' => function ($query) use ($UserSelectView) {
                    $query->select($UserSelectView);
                },
                'resume_meta_data' => function ($q) {
                    $q->orderBy('meta_data->date', 'DESC');
                }
            ]
        )->select($ResumeSelectView)->where('access_resume', 'all')->orderBy('created_at', 'desc')->find($id);


        $Resume['user_tbl']['province'] = HomeController::selectState('number', $Resume->user_tbl->province);
        $Resume['user_tbl']['gender'] = HomeController::ConvertGender($Resume->user_tbl->gender);
        $Resume['user_tbl']['full_name'] = $HasBuyer ? $Resume->user_tbl->full_name : HomeController::Censor($Resume->user_tbl->full_name);
        $Resume['birth_day'] = $HasBuyer ? substr_replace($Resume->birth_day, '', -6, 6) : substr_replace($Resume->birth_day, '', -6, 6);
        $Resume['salary'] = HomeController::ConvertSalary($Resume->salary);
        $Resume['confidence'] = HomeController::CheckConfidence($Resume->id);
        $Resume['skills'] = HomeController::GetCompanyCategory($Resume->skills) ? HomeController::GetCompanyCategory($Resume->skills)->title : 'مشخص نشده';
        $Resume['avatar'] = $HasBuyer ? HomeController::GetAvatar('92', '246', HomeController::GetUserData($Resume->uid, 'avatar')) : HomeController::AvatarGenerate(HomeController::GetUserData($Resume->uid, 'gender_org'));
        $Resume['bg_level'] = HomeController::BackgroundLevel($Resume->level);
        $Resume['has_buyer'] = $HasBuyer;
        $Resume['percentage'] = HomeController::CheckResumePercentage($Resume->id);
        if ($HasBuyer) {
            $ResumeFile = FileLibrary::find($Resume->resume_file);
            $Resume['resume_file'] = $ResumeFile ? url('storage/' . $ResumeFile->path . '/' . $ResumeFile->file_name) : '';
        } else {
            $Resume['cost'] = HomeController::CalculateTopliByLevel($Resume->level);
        }
        if ($User) {
            $Resume['confirmed'] = HomeController::CheckResumeConfirmed($Resume->id, $User);
        } else {
            $Resume['confirmed'] = null;
        }
//        $Resume['work_history'] = array_filter(json_decode($Resume->resume_meta_data, true), function($value) {
//            return $value['type'] == 'work_history';
//        });

        unset($Resume['skill']);
//        unset($Resume['resume_meta_data']);

        $ResumeIntroducer = ResumeIntroducer::with(
            [
                'employment_tbl' => function ($query) {
                    $query->addSelect('company_name_fa', 'avatar', 'biography', 'avatar');
                },
            ]
        )->where('resume_id', $Resume->id)
            ->select($ResumeIntroducerSelectView)->orderBy('created_at', 'desc')->get()->take(5);

        foreach ($ResumeIntroducer as $key => $item) {
            $ResumeIntroducer[$key]['company_name_fa'] = $item->employment_tbl->company_name_fa;
            $ResumeIntroducer[$key]['company_biography'] = HomeController::TruncateString($item->employment_tbl->biography, 700, 700);
            $ResumeIntroducer[$key]['comment_employment'] = $item->comment_employment;
            $ResumeIntroducer[$key]['expert_opinion'] = $item->expert_opinion;
            $ResumeIntroducer[$key]['avatar'] = HomeController::GetAvatar('63', '126', $item->employment_tbl->avatar);
            $ResumeIntroducer[$key]['expertise'] = $item->expertise;
            $ResumeIntroducer[$key]['personality'] = $item->personality;
            $ResumeIntroducer[$key]['experience'] = $item->experience;
            $ResumeIntroducer[$key]['software'] = $item->software;
            $ResumeIntroducer[$key]['organizational_behavior'] = $item->organizational_behavior;
            $ResumeIntroducer[$key]['passion'] = $item->passion;
            $ResumeIntroducer[$key]['salary_rate'] = $item->salary_rate;
            $ResumeIntroducer[$key]['confidence'] = $item->confidence;

            if ($HasBuyer) {
                if ($item->interview_file) {
                    $InterviewFile = FileLibrary::find($item->interview_file);
                    $ResumeIntroducer[$key]['interview_file'] = url('storage/' . $InterviewFile->path . $InterviewFile->file_name);
                }

                if ($item->voice) {
                    $VoiceFile = FileLibrary::find($item->voice);
                    $ResumeIntroducer[$key]['voice'] = url('storage/' . $VoiceFile->path . '/' . $VoiceFile->file_name);
                }
            }

            unset($item['employment_tbl']);
        }

        $Resume['Introducer'] = $ResumeIntroducer;

        $Resume['work_experience'] = WorkExperience::where('resume_id', $Resume->id)->where('status', '!=', 'pending')->select('id')->get();

        return response()->json($Resume);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public
    function edit($id)
    {
        $Resume = ResumeManager::with(['user_tbl.avatar', 'resume_file_tbl'])->find($id);
        $ResumeIntroducer = ResumeIntroducer::with(['employment_tbl', 'interview_file_tbl', 'voice_file_tbl'])->where('resume_id', $id)->get();
//        $Specialty = EmploymentAdvertisementPersonalProficiency::get()->all();
        $Skills = EmploymentAdvertisementCategory::get()->all();

        $Resume['resume_introducer'] = $ResumeIntroducer;

        if ($Resume->status == 'new') {
            $Resume->update(['status' => 'pending_operator']);
        }

        $Data = [
            'Resume',
//            'Specialty',
            'Skills'
        ];

        return view('resumemanager::edit', compact($Data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public
    function update(ResumeManagerSuperAdminRequest $request, $id)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }
        $Resume = ResumeManager::find($id);

        $CheckUserExists = Users::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        /* JobSeeker Check of EmploymentID  */
        if ($CheckUserExists) {
            if ($CheckUserExists->role == 'employer') {
                return response()->json(['status' => 301]);
            }

//            $OwnerJobSeekerExistCheck = ResumeIntroducer::where('job_seeker_id', $CheckUserExists->id)->where('employment_id', $User)->first();
//            if ($OwnerJobSeekerExistCheck) {
//                return response()->json(['status' => 301]);
//            }
        }

        $ResumeData = $request->all();
        $Userdata['full_name'] = $request->full_name;
        $Userdata['email'] = $request->email;
        $Userdata['phone'] = $request->phone;
        $Userdata['province'] = $request->province;
        $Userdata['city'] = $request->city;
        $Userdata['district'] = $request->district;
        $Userdata['gender'] = $request->gender;

        if ($request->file('avatar')) {
            $Userdata['avatar'] = FileLibraryController::upload($request->file('avatar'), 'image', 'users/avatar', 'users', array([35, 35, 'fit'], [46, 46, 'fit'], [63, 63, 'fit'], [70, 70, 'fit'], [92, 92, 'fit'], [126, 126, 'fit'], [246, 246, 'fit'], [600, 600, 'fit']));
        }

//        $ResumeData['specialty'] = json_encode($request->specialty);

        if (Users::find($Resume->uid)->update($Userdata)) {

            if ($request->file('resume_file')) {
                $ResumeData['resume_file'] = FileLibraryController::upload($request->file('resume_file'), 'file', 'resume/cv', 'resume');
            }

//            if ($request->file('interview_file')) {
//                $ResumeData['interview_file'] = FileLibraryController::upload($request->file('interview_file'), 'file', 'resume/interview', 'resume');
//            }
//
//            if ($request->file('voice')) {
//                $ResumeData['voice'] = FileLibraryController::upload($request->file('voice'), 'file', 'resume/voice', 'resume');
//            }

            if ($Resume->status != 'pending_job_seeker' && $request->status == 'pending_job_seeker') {
                $HaveSMS = true;
            } else {
                $HaveSMS = false;
            }

            if ($request->requirements) {
                $ResumeData['requirements'] = json_encode($request->requirements);
            } else {
                $ResumeData['requirements'] = null;
            }

            if ($Resume->update($ResumeData)) {
                if ($HaveSMS) {
                    SmsHandlerController::SmsHandlerByPattern('117652', $request->phone, 'JOBTITLE', $request->job_position);
                    $content = '<p>كارجوی گرامی<br>با سلام<br>خوشحالیم كه رزومه شما را در پلتفرم تاپلیكنت مشاهده میكنیم. امیدواریم بتوانیم به شما كمك كنیم تا شغلی را پیدا كنید كه بهترین تناسب را با شما دارد.</p><p>رزومه شما در سایت Toplicant.com برای استخدام با عنوان شغلی ' . $request->job_position . ' توصیه شده است. خواهشمند است در صورتی كه تمایل دارید رزومه شما توسط سازمانها قابل مشاهده باشد، از طریق لینك زیر وارد پلتفرم جذب و استخدام تاپلیكنت شده و فرایند اصلاح، تكمیل و تایید اطلاعات مورد نیاز را به انجام برسانید.</p><p>آدرس لینك<br><a href="' . 'https://' . env('APP_URL') . '">تاپلیكنت؛ پلی برای متقاضیان برگزیده</a></p>';
                    MailController::sendMail($request->email, 'به تاپلیکنت خوش آمدید', $request->full_name, $content);
                }

                if ($Resume->status == 'new') {
                    return redirect('dashboard/resume-manager')->with('notification', [
                        'class' => 'success',
                        'message' => 'اطلاعات بروزرسانی شد'
                    ]);
                } else {
                    return redirect()->back()->with('notification', [
                        'class' => 'success',
                        'message' => 'اطلاعات بروزرسانی شد'
                    ]);
                }
            } else {
                return redirect('dashboard/resume-manager')->with('notification', [
                    'class' => 'danger',
                    'message' => 'بروزرسانی با خطا روبرو شد'
                ]);
            }
        } else {
            return redirect('dashboard/resume-manager')->with('notification', [
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
    public
    function destroy($id)
    {
        //
    }

    /**
     * set resume confirm status *
     */
    public
    function resume_confirm(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $ResumeConfirm['employer_id'] = $User;
        $ResumeConfirm['resume_id'] = (int)$request->id;
        $ResumeConfirm['status'] = $request->status;

        if (ResumeIntroducer::where('employment_id', $User)->where('resume_id', $request->id)->count()) {
            return response()->json(['resume' => $request->id, 'status' => 401]);
        } else {
            if (ResumeConfirmReject::create($ResumeConfirm)) {
                return response()->json(['result' => $request->status, 'resume' => $request->id, 'status' => 200]);
            }
        }
    }

    /*
     * Set Purchase Result
     * Route: /api/set-purchase-result
     * Method: POST
     * */
    public
    function PurchaseResult(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Purchase = PurchasedResumes::where('buyer_id', $User)->where('resume_id', $request->id)->first();
        $MyWallet = Wallet::where('uid', $User)->first();
        $Resume = ResumeManager::select('level', 'uid')->find($request->id);

        $PurchaseData = [];
        if ($request->status === 'hired') {
            $PurchaseData['result'] = 'hired';

            $ResumeIntroducer = ResumeIntroducer::where('resume_id', $request->id)->where('status', 'sold')->get();
            $Score = HomeController::CalculateTopliByLevel($Resume->level, 10);
            $MyWallet->update([
                'topli_score' => $MyWallet->topli_score + $Score
            ]);

            OrderManagement::create([
                'uid' => $User,
                'type' => 'receive',
                'title' => 'استخدام ' . HomeController::GetUserData($Resume->uid, 'name') . ' انجام شد.',
                'object' => 'ثبت بازخورد',
                'score' => $Score
            ]);

            foreach ($ResumeIntroducer as $item) {
                $item->update(['status' => 'hired']);
                $Wallet = Wallet::where('uid', $item->employment_id)->first();
                $TopliScore = HomeController::CalculateTopliByLevel($Resume->level, 40);
                $Wallet->update([
                    'topli_score' => $Wallet->topli_score + $TopliScore
                ]);

                OrderManagement::create([
                    'uid' => $item->employment_id,
                    'type' => 'receive',
                    'title' => 'استخدام ' . HomeController::GetUserData($Resume->uid, 'name') . ' انجام شد.',
                    'object' => 'ثبت بازخورد',
                    'score' => $TopliScore
                ]);
            }
        } elseif ($request->status === 'not_hired') {
//            $PurchaseData['result'] = 'not_hired';

//            $Score = HomeController::CalculateTopliByLevel($Resume->level, 70);
//            $MyWallet->update([
//                'topli_score' => $MyWallet->topli_score + $Score
//            ]);
//
//            OrderManagement::create([
//                'uid' => $User,
//                'type' => 'receive',
//                'title' => HomeController::GetUserData($Resume->uid, 'name') . ' استخدام نشد.',
//                'object' => 'ثبت بازخورد',
//                'score' => $Score
//            ]);
        } elseif ($request->status === 'extended') {
            $PurchaseData['result'] = 'extended';

            $ResumeIntroducer = ResumeIntroducer::where('resume_id', $request->id)->where('status', 'hired')->get();
//            $Score = HomeController::CalculateTopliByLevel($Resume->level, 5);
//            $MyWallet->update([
//                'topli_score' => $MyWallet->topli_score + $Score
//            ]);
//
//            OrderManagement::create([
//                'uid' => $User,
//                'type' => 'receive',
//                'title' => 'تمدید استخدام ' . HomeController::GetUserData($Resume->uid, 'name') . ' انجام شد.',
//                'object' => 'ثبت بازخورد',
//                'score' => $Score
//            ]);

            foreach ($ResumeIntroducer as $item) {
                $item->update(['status' => 'extended']);
                $Wallet = Wallet::where('uid', $item->employment_id)->first();
                $TopliScore = HomeController::CalculateTopliByLevel($Resume->level, 10);
//                $Wallet->update([
//                    'topli_score' => $Wallet->topli_score + $TopliScore
//                ]);
//
//                OrderManagement::create([
//                    'uid' => $item->employment_id,
//                    'type' => 'receive',
//                    'title' => 'استخدام ' . HomeController::GetUserData($Resume->uid, 'name') . ' تمدید شد.',
//                    'object' => 'ثبت بازخورد',
//                    'score' => $TopliScore
//                ]);
            }
        } else {
            $PurchaseData['result'] = null;
        }

        if ($Purchase->update($PurchaseData)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 401]);
        }
    }

    /*
     * Set Reason Not Hiring
     * Route: /api/set-purchase-result
     * Route: /api/get-purchased-resume-data
     * Method: POST
     * */
    public function GetPurchasedResumeData($id)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Purchase = PurchasedResumes::where('buyer_id', $User)->where('resume_id', $id)->first();

        $Resume = ResumeManager::select('level', 'uid')->find($Purchase->resume_id);
        /*Discount */
        $Resume->cost = (70 / 100) * $Purchase->amount;
        $Resume->full_name = HomeController::GetUserData($Resume->uid);
        $Resume->reasons = json_decode($Purchase->reasons, true);

        return response()->json(['status' => 200, 'resume' => $Resume]);
    }

    /*
     * Set Reason Not Hiring
     * Route: /api/set-purchase-result
     * Method: POST
     * */
    public function ReasonNotHiring(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Purchase = PurchasedResumes::where('buyer_id', $User)->where('resume_id', $request->id)->first();
        $Resume = ResumeManager::select('uid', 'level')->find($request->id);
        $PurchaseData = [];

        if ($Purchase) {
//            if ($Purchase->result === 'not_hired') {
            $PurchaseData['reasons'] = json_encode($request->reasons);

            /* Set Cost */
            if ($Purchase->reasons == null) {
                $MyWallet = Wallet::where('uid', $User)->first();
                /*Discount */
                $Score = (70 / 100) * $Purchase->amount;
                $MyWallet->update([
                    'topli_score' => $MyWallet->topli_score + $Score
                ]);

                OrderManagement::create([
                    'uid' => $User,
                    'type' => 'receive',
                    'title' => 'دلایل عدم استخدام ' . HomeController::GetUserData($Resume->uid) . ' ثبت شد.',
                    'object' => 'ثبت بازخورد',
                    'score' => $Score
                ]);
            }

            $PurchaseData['result'] = 'not_hired';
            if ($Purchase->update($PurchaseData)) {
                return response()->json(['status' => 200]);
            }
//            } else {
//                return response()->json(['status' => 401]);
//            }
        } else {
            return response()->json(['status' => 401]);
        }
    }

    /**
     * Resume edit page data on panel
     **/
    public
    function resume_edit($id)
    {
        $ResumeIntroducer = ResumeIntroducer::with(['voice_file_tbl', 'interview_file_tbl'])->
        select('resume_id', 'recognition', 'confidence', 'expertise', 'personality', 'experience', 'software', 'organizational_behavior', 'passion', 'salary_rate', 'reason_adjustment', 'expert_opinion', 'comment_employment', 'interview_file', 'voice')->find($id);

        $Resume = ResumeManager::with(['user_tbl', 'resume_file_tbl'])->
        select('id', 'uid', 'cooperation_type', 'presence_type', 'job_position', 'level', 'sarbazi', 'birth_day', 'access_resume', 'salary', 'specialty', 'resume_file', 'skills', 'status')->find($ResumeIntroducer->resume_id);

        /* Get Avatar */
        $UserData = [];
        if ($Resume->user_tbl->avatar) {
            $UserAvatar = FileLibrary::find($Resume->user_tbl->avatar);

            if ($UserAvatar->extension != 'svg') {
                $UserData['avatar']['path'] = url('storage/' . $UserAvatar->path . '126/' . $UserAvatar->file_name);
                $UserData['avatar']['pathX2'] = url('storage/' . $UserAvatar->path . '246/' . $UserAvatar->file_name);
            } else {
                $UserData['avatar']['path'] = url('storage/' . $UserAvatar->path . 'full/' . $UserAvatar->file_name);
            }

            if ($Resume->user_tbl->role === 'employer' || $Resume->user_tbl->role === 'admin') {
                $UserData['company_name_fa'] = $Resume->user_tbl->company_name_fa;
            }
        } else {
            $UserData['avatar'] = '';
        }

        /* Merge Resume Introducer Table */
        $Resume['recognition'] = $ResumeIntroducer->recognition;
        $Resume['confidence'] = $ResumeIntroducer->confidence;
        $Resume['confidence'] = $ResumeIntroducer->confidence;
        $Resume['expertise'] = $ResumeIntroducer->expertise;
        $Resume['personality'] = $ResumeIntroducer->personality;
        $Resume['experience'] = $ResumeIntroducer->experience;
        $Resume['software'] = $ResumeIntroducer->software;
        $Resume['organizational_behavior'] = $ResumeIntroducer->organizational_behavior;
        $Resume['passion'] = $ResumeIntroducer->passion;
        $Resume['salary_rate'] = $ResumeIntroducer->salary_rate;
        $Resume['reason_adjustment'] = $ResumeIntroducer->reason_adjustment;
        $Resume['comment_employment'] = $ResumeIntroducer->comment_employment;
        $Resume['expert_opinion'] = $ResumeIntroducer->expert_opinion;
        $Resume['interview_file'] = $ResumeIntroducer->interview_file_tbl;
        $Resume['voice'] = $ResumeIntroducer->voice_file_tbl;

        if ($ResumeIntroducer->voice) {
            $VoiceFile = FileLibrary::find($ResumeIntroducer->voice);
            $Resume['voice'] = url('storage/' . $VoiceFile->path . $VoiceFile->file_name);
        }


        $EmploymentAdvertisementCategory = EmploymentAdvertisementCategory::orderBy('title', 'desc')->get()->all();
        $EmploymentAdvertisementProficiency = EmploymentAdvertisementProficiency::orderBy('title', 'desc')->get()->all();
        $EmploymentAdvertisementPersonalProficiency = EmploymentAdvertisementPersonalProficiency::orderBy('title', 'desc')->get()->all();

        $Taxonomies = [
            'Category' => $EmploymentAdvertisementCategory,
            'Proficiency' => $EmploymentAdvertisementProficiency,
            'PersonalProficiency' => $EmploymentAdvertisementPersonalProficiency,
        ];

        if ($Resume['status'] === 'toplicant_reject' || $Resume['status'] === 'pending_operator') {
            return response()->json([$Resume, $UserData, $Taxonomies, 'status' => 200]);
        } else {
            return response()->json(['status' => 401]);
        }
    }

    /**
     * Resume Update on employer panel
     **/
    public function resume_update(ResumeManagerRequest $request, $id)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $ResumeIntroducer = ResumeIntroducer::find($id);
        $Resume = ResumeManager::find($ResumeIntroducer->resume_id);

        $CheckUserExists = Users::where('email', $request->email)->orWhere('phone', $request->phone)->first();

        /* JobSeeker Check of EmploymentID  */
        if ($CheckUserExists) {
            if ($CheckUserExists->role == 'employer') {
                return response()->json(['status' => 301]);
            }

            $OwnerJobSeekerExistCheck = ResumeIntroducer::where('job_seeker_id', $CheckUserExists->id)->where('employment_id', $User)->count();
            if ($OwnerJobSeekerExistCheck > 1) {
                return response()->json(['status' => 301]);
            }
        }

        function isJSON($string)
        {
            return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
        }

        $Userdata = [];
        $Userdata['full_name'] = $request->full_name;
        $Userdata['email'] = $request->email;
        $Userdata['phone'] = $request->phone;
        $Userdata['province'] = $request->province;
        if ($request->city) {
            $Userdata['city'] = $request->city;
        }
        if ($request->district) {
            $Userdata['district'] = $request->district;
        }
        $Userdata['gender'] = $request->gender;

        if ($request->file('avatar')) {
            $Userdata['avatar'] = FileLibraryController::upload($request->file('avatar'), 'image', 'users/avatar', 'users', array([35, 35, 'fit'], [46, 46, 'fit'], [63, 63, 'fit'], [70, 70, 'fit'], [92, 92, 'fit'], [126, 126, 'fit'], [246, 246, 'fit'], [600, 600, 'fit']));
        } elseif ($request->removeAvatar != 'false') {
            $Userdata['avatar'] = null;
        }


        if ($Resume['status'] === 'toplicant_reject' || $Resume['status'] === 'pending_operator') {
            if (Users::find($ResumeIntroducer->job_seeker_id)->update($Userdata)) {
                $ResumeData = $request->all();

//            if ($ResumeData['specialty'] != $Resume->specialty) {
//                $ResumeData['specialty'] = json_encode(explode(',', $request->specialty));
//            } else {
//                $ResumeData['specialty'] = $Resume->specialty;
//            }

                if ($request->resume_file || $request->file('resume_file')) {
                    $ResumeData['resume_file'] = FileLibraryController::upload($request->file('resume_file'), 'file', 'resume/cv', 'resume');
                } elseif ($request->removeResumeFile != 'false') {
                    $ResumeData['resume_file'] = null;
                }

                if ($Resume->update($ResumeData)) {
                    $ResumeIntroducerData = $request->all();
                    $ResumeIntroducerData['comment_employment'] = $request->comment_employment ? : '';
                    $ResumeIntroducerData['expert_opinion'] = $request->expert_opinion ? : '';


                    if ($request->interview_file || $request->file('interview_file')) {
                        $ResumeIntroducerData['interview_file'] = FileLibraryController::upload($request->file('interview_file'), 'file', 'resume/interview', 'resume');
                    } elseif ($request->removeInterviewFile != 'false') {
                        $ResumeIntroducerData['interview_file'] = null;
                    }

                    if ($request->voice || $request->file('voice' || $request->voice != null)) {
                        $ResumeIntroducerData['voice'] = FileLibraryController::upload($request->file('voice'), 'file', 'resume/voice', 'resume');
                    } elseif ($request->removeVoice != 'false') {
                        $ResumeIntroducerData['voice'] = null;
                    }

                    if (ResumeIntroducer::find($id)->update($ResumeIntroducerData)) {
                        return response()->json(['data' => $request->all(), 'status' => 200]);
                    }

                }
            }
        } else {
            return response()->json(['data' => $request->all(), 'status' => 401]);
        }
    }

    /**
     * Get Resume by IDs
     **/
    public function getResumeByIDsCart(Request $request)
    {

        if (auth('sanctum')->check()) {
            if (auth('sanctum')->user()->parent_id) {
                $User = Auth::user()->parent_id;
            } else {
                $User = auth('sanctum')->user()->id;
            }
        } else {
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('optimize:clear');
            \Cookie::queue(\Cookie::forget('userData'));
            \Cookie::queue(\Cookie::forget('toplicant_session'));
            \Cookie::queue(\Cookie::forget('XSRF-TOKEN'));
            \Cookie::queue(\Cookie::forget('auth_token'));

            return response()->json([
                'status' => 401,
            ]);
        }

        $Resume = [];
        $ids = explode(',', $request->ids);
        $PaymentStatus = 1;

        foreach ($ids as $id) {
            $PurchasedResumes = PurchasedResumes::where('buyer_id', $User)->where('resume_id', $id)->select('resume_id')->get()->all();
            $PurchasedResumesIDs = [];
            if (count($PurchasedResumes)) {
                foreach ($PurchasedResumes as $item) {
                    array_push($PurchasedResumesIDs, $item->resume_id);
                }
            }

            if (!$PurchasedResumesIDs == $id) {
                $ResumeItem = ResumeManager::where('status', 'accept_job_seeker')->with(
                    [
                        'user_tbl' => function ($query) {
                            $query->select('id', 'full_name');
                        }
                    ]
                )->select('id', 'uid', 'level', 'job_position')->find($id);

                if (auth('sanctum')->check()) {
                    if (auth('sanctum')->user()->parent_id) {
                        $User = Auth::user()->parent_id;
                    } else {
                        $User = auth('sanctum')->user()->id;
                    }

                    if (ResumeIntroducer::where('employment_id', $User)->where('resume_id', $id)->select('resume_id')->count()) {
                        $PaymentStatus = 0;
                        $ResumeItem->owner = true;
                    }
                }

                array_push($Resume, $ResumeItem);
            }
        }

        $Topli = 0;

        if ($Resume) {
            foreach ($Resume as $key => $item) {
                $Resume[$key]['full_name'] = HomeController::Censor($item->user_tbl->full_name);
                $Topli += HomeController::CalculateTopliByLevel($item->level, 100);
                $Resume[$key]['avatar'] = HomeController::AvatarGenerate(HomeController::GetUserData($item->uid, 'gender_org'));
                unset($Resume[$key]['uid']);
                unset($Resume[$key]['user_tbl']);
            }

            /* Discount */
            $Topli = $Topli - ((70 / 100) * $Topli);
        }

        return response()->json([$Resume, 'topli' => $Topli, 'payment_status' => $PaymentStatus]);
    }

    /**
     * Get Last Resume by count
     **/
    public function getLastResume($count)
    {
        $RejectResumesIDs = [];

        if (auth('sanctum')->check()) {
            if (auth('sanctum')->user()->parent_id) {
                $User = Auth::user()->parent_id;
            } else {
                $User = auth('sanctum')->user()->id;
            }

            $RejectResumes = ResumeConfirmReject::where('employer_id', $User)->where('status', 'reject')->get()->all();

            if (count($RejectResumes)) {
                foreach ($RejectResumes as $item) {
                    array_push($RejectResumesIDs, $item->resume_id);
                }
            }
        }

        $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->where('status', 'accept_job_seeker')->where('access_resume', 'all')->where('job_status', '!=', 'sold')->with(
            [
                'user_tbl' => function ($query) {
                    $query->select('id', 'full_name', 'province', 'city');
                },
            ]
        )->select('id', 'uid', 'job_position', 'level')->orderBy('created_at', 'desc')->get()->take($count);

        $Resume1 = array();
        foreach ($Resume as $key => $item) {
            if ($ResumeIntroducer = ResumeIntroducer::where('resume_id', $item->id)->orderBy('id', 'desc')->first()) {
                $Resume[$key]['expertise'] = $ResumeIntroducer->expertise;
                $Resume[$key]['personality'] = $ResumeIntroducer->personality;
                $Resume[$key]['experience'] = $ResumeIntroducer->experience;
                $Resume[$key]['software'] = $ResumeIntroducer->software;
                $Resume[$key]['organizational_behavior'] = $ResumeIntroducer->organizational_behavior;
                $Resume[$key]['passion'] = $ResumeIntroducer->passion;
                $Resume[$key]['salary_rate'] = $ResumeIntroducer->salary_rate;
                $Resume[$key]['confidence'] = HomeController::CheckConfidence($item->id);
                $Resume[$key]['bg_level'] = HomeController::BackgroundLevel($item->level);
                $Resume[$key]['province'] = HomeController::selectState('number', $item->user_tbl->province);
                $Resume[$key]['city'] = $item->user_tbl->city;
                $Resume[$key]['avatar'] = HomeController::AvatarGenerate(HomeController::GetUserData($item->uid, 'gender_org'));
                $Resume[$key]['percentage'] = HomeController::CheckResumePercentage($item->id);
                $Resume[$key]['user_tbl']['full_name'] = HomeController::Censor($item->user_tbl->full_name);
                array_push($Resume1, $item);
            } else {
                unset($Resume[$key]);
            }
        }

        if (count($Resume1)) {
            foreach ($Resume1 as $key => $item) {
                $Resume1[$key]['user_tbl']['full_name'] = HomeController::Censor($item->user_tbl->full_name);
//                unset($Resume[$key]['skill_tbl']['id']);
                unset($Resume1[$key]['user_tbl']['id']);
                unset($Resume1[$key]['user_tbl']['province']);
                unset($Resume1[$key]['user_tbl']['city']);
            }
        }

        return response()->json($Resume1);
    }

    /**
     * Get all resume paginate
     **/
    public function getAllResumes(Request $request)
    {
        $RejectResumesIDs = [];

        if (auth('sanctum')->check()) {
            if (auth('sanctum')->user()->parent_id) {
                $User = Auth::user()->parent_id;
            } else {
                $User = auth('sanctum')->user()->id;
            }

            $RejectResumes = ResumeConfirmReject::where('employer_id', $User)->where('status', 'reject')->get()->all();

            if (count($RejectResumes)) {
                foreach ($RejectResumes as $item) {
                    array_push($RejectResumesIDs, $item->resume_id);
                }
            }
        }

        $Resume = ResumeManager::whereNotIn('id', $RejectResumesIDs ? $RejectResumesIDs : [])->where('status', 'accept_job_seeker')->with(
            [
                'user_tbl' => function ($query) {
                    $query->select('id', 'full_name', 'city', 'province');
                },
                'introducer_tbl' => function ($query) {
                    $query->select('id', 'confidence');
                },
            ]
        )->where(function ($query) use ($request) {
            if ($request->job_position) {
                $query->where('job_position', 'like', '%' . $request->job_position . '%');
            }

            if ($request->cat) {
                $query->where('skills', '=', $request->cat);
            }
//            if ($request->personal_proficiency) {
//                foreach ($request->personal_proficiency as $key => $item) {
//                    if ($key == 0) {
//                        $query->whereRaw('json_contains(specialty, \'["' . $item . '"]\')');
//                    } else {
//                        $query->orWhereRaw('json_contains(specialty, \'["' . $item . '"]\')');
//                    }
//                }
//            }
        })
            ->whereHas('user_tbl', function ($query) use ($request) {
                if ($request->province) {
                    foreach ($request->province as $key => $item) {
                        $ProvinceCode = HomeController::selectState('name', $item);
                        if ($key == 0) {
                            $query->where('province', '=', $ProvinceCode);
                        } else {
                            $query->orWhere('province', '=', $ProvinceCode);
                        }
                    }
                }
            })->whereHas('introducer_tbl', function ($query) use ($request) {
                if ($request->confidence) {
                    $query->where('confidence', '=', 'چک شده و کاملا مثبت');
                    $query->orWhere('confidence', '=', 'مثبت ولی می تواند بیشتر چک شود');
                }
            })
            ->where('access_resume', 'all')->select('id', 'uid', 'level', 'job_position')->orderBy('created_at', 'desc')->where('job_status', '!=', 'sold')->paginate(15);

        if (count($Resume)) {
            foreach ($Resume as $key => $item) {
                $ResumeIntroducer = ResumeIntroducer::where('resume_id', $item->id)->orderBy('id', 'desc')->first();
                $Resume[$key]['expertise'] = $ResumeIntroducer->expertise;
                $Resume[$key]['personality'] = $ResumeIntroducer->personality;
                $Resume[$key]['experience'] = $ResumeIntroducer->experience;
                $Resume[$key]['software'] = $ResumeIntroducer->software;
                $Resume[$key]['organizational_behavior'] = $ResumeIntroducer->organizational_behavior;
                $Resume[$key]['passion'] = $ResumeIntroducer->passion;
                $Resume[$key]['salary_rate'] = $ResumeIntroducer->salary_rate;
                $Resume[$key]['confidence'] = HomeController::CheckConfidence($item->id);
                $Resume[$key]['bg_level'] = HomeController::BackgroundLevel($item->level);
                $Resume[$key]['province'] = HomeController::selectState('number', $item->user_tbl->province);
                $Resume[$key]['city'] = $item->user_tbl->city;
                $Resume[$key]['avatar'] = HomeController::AvatarGenerate(HomeController::GetUserData($item->uid, 'gender_org'));
                $Resume[$key]['percentage'] = HomeController::CheckResumePercentage($item->id);
                $Resume[$key]['user_tbl']['full_name'] = HomeController::Censor($item->user_tbl->full_name);
            }
        }
        return response()->json($Resume);
    }

    /**
     * Show my Resume on panel
     **/
    public function MyResumeData()
    {
        $Resume = ResumeManager::where('uid', \auth('sanctum')->user()->id)->with(['user_tbl', 'user_tbl.avatar_tbl', 'resume_file_tbl'])->select('id', 'uid', 'resume_file', 'salary', 'specialty', 'level', 'birth_day', 'sarbazi', 'job_position', 'education', 'experience', 'job_status', 'linkedin', 'dribbble')->first();
        $ResumeIntroducer = ResumeIntroducer::with(['employment_tbl'])->where('resume_id', $Resume->id)->orderBy('id', 'desc')->first();

        /* Avatar */
        if ($Resume->user_tbl->avatar) {
            if ($Resume->user_tbl->avatar_tbl->extension != 'svg') {
                $Resume['avatar'] = [
                    'path' => url('storage/' . $Resume->user_tbl->avatar_tbl->path . '63/' . $Resume->user_tbl->avatar_tbl->file_name),
                    'pathX2' => url('storage/' . $Resume->user_tbl->avatar_tbl->path . '126/' . $Resume->user_tbl->avatar_tbl->file_name)
                ];
            } else {
                $Resume['avatar'] = [
                    'path' => url('storage/' . $Resume->user_tbl->avatar_tbl->path . 'full/' . $Resume->user_tbl->avatar_tbl->file_name),
                ];
            }
        } else {
            $Resume['avatar'] = [
                'path' => '',
                'pathX2' => ''
            ];
        }

        /* Resume File */
        if ($Resume->resume_file) {
            $Resume['resume'] = [
                'path' => url('storage/' . $Resume->resume_file_tbl->path . '/' . $Resume->resume_file_tbl->file_name),
            ];
        }

        $Resume['company_name'] = $ResumeIntroducer->employment_tbl->company_name_fa;
        $Resume['salary'] = HomeController::ConvertSalary($Resume->salary);
        $Resume['user_tbl']['province'] = HomeController::selectState('number', $Resume->user_tbl->province);
        $Resume['user_tbl']['gender'] = HomeController::ConvertGender($Resume->user_tbl->gender);

//        if ($Resume->specialty) {
//            $Speciality = json_decode($Resume->specialty);
//            $SpecialtyArray = [];
//
//            foreach ($Speciality as $item) {
//                $Lable = EmploymentAdvertisementPersonalProficiency::find($item);
//                array_push($SpecialtyArray, $Lable->title);
//            }
//
//            $Resume['specialty'] = $SpecialtyArray;
//        }

        /* Un Set Additional Data */
        unset($Resume['user_tbl']['avatar']);
        unset($Resume['user_tbl']['avatar_tbl']);
        unset($Resume['resume_file']);
        unset($Resume['uid']);
        unset($Resume['resume_file_tbl']);

        return response()->json($Resume);
    }

    /**
     * Update JobSeeker Profile
     * @api /api/my-resume-data-store
     * @Method POST
     **/
    public function MyResumeDataStore(UpdateMyResumeRequest $request)
    {
        $Resume = ResumeManager::where('uid', auth()->user()->id)->first();
        $Resume = ResumeManager::find($Resume->id);

        $ResumeData = [];
        $UserData = [];

        $ResumeData['dribbble'] = $request->dribbble;
        $ResumeData['linkedin'] = $request->linkedin;
        $ResumeData['education'] = $request->education;
        $ResumeData['experience'] = $request->experience;
        $ResumeData['job_status'] = $request->job_status;
        if ($Resume->status === 'toplicant_reject') {
            $ResumeData['status'] = 'toplicant_reject';
        } else {
            $ResumeData['status'] = 'accept_job_seeker';
        }


        if ($Resume->status === 'pending_job_seeker') {
            $GetTopli = true;

            $ResumeData['confirm_date'] = Carbon::now()->toDateTimeString();
        } else {
            $GetTopli = false;
        }

        if ($request->file('avatar')) {
            $UserData['avatar'] = FileLibraryController::upload($request->file('avatar'), 'image', 'users/avatar', 'users', array([35, 35, 'fit'], [46, 46, 'fit'], [63, 63, 'fit'], [70, 70, 'fit'], [92, 92, 'fit'], [126, 126, 'fit'], [246, 246, 'fit'], [600, 600, 'fit']));
        }
        $UserData['district'] = $request->district;
        $User = Users::find($Resume->uid);


        if ($User->update($UserData)) {
            if ($Resume->update($ResumeData)) {
//                if ($GetTopli) {
//                    $ResumeIntroducer = ResumeIntroducer::with(['employment_tbl'])->where('resume_id', $Resume->id)->orderBy('id', 'desc')->first();
//                    $IntroducerWallet = Wallet::where('uid', $ResumeIntroducer->employment_id)->first();
//                    $IntroducerWallet->update(['topli_score' => $IntroducerWallet->topli_score + HomeController::CalculateTopliByLevel($Resume->level, 10)]);
//                    OrderManagement::create([
//                        'uid' => $ResumeIntroducer->employment_id,
//                        'title' => 'ثبت روزمه پلاس ' . $User->full_name,
//                        'object' => 'معرفی رزومه +',
//                        'score' => HomeController::CalculateTopliByLevel($Resume->level, 10)
//                    ]);
//                }

                return response()->json(['data' => $ResumeData, 'status' => 200]);
            }
        }
    }

    public
    function ResumeRequirements($id)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $ResumeIntroducer = ResumeIntroducer::where('resume_id', $id)->where('employment_id', $User)->count();

        if ($ResumeIntroducer <= 0) {
            return response()->json(['status' => 401]);
        }

        $Resume = ResumeManager::select('requirements')->find($id);

        return response()->json(['status' => 200, 'data' => json_decode($Resume->requirements, true)]);
    }
}
