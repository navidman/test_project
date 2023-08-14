<?php

namespace Modules\ResumeManager\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\ResumeManager\Entities\WorkExperience;
use Modules\ResumeManager\Http\Requests\WorkExperienceRequest;

class WorkExperienceController extends Controller
{
    /*
     * Store Work Experience
     * Route: /api/work-experience
     * POST
     * */
    public function getOwnerWorkExperience()
    {
        $User = auth()->user()->id;

        $Resume = ResumeManager::where('uid', $User)->select('id')->first();

        $WorkExperience = WorkExperience::where('resume_id', $Resume->id)->select('id', 'full_name', 'email', 'phone', 'company_name', 'cooperation_period', 'cooperation_type', 'linkedin')->get()->all();

        return response()->json($WorkExperience);
    }

    /*
     * Store Work Experience
     * Route: /api/work-experience
     * POST
     * */
    public function store(WorkExperienceRequest $request)
    {
        $User = auth()->user()->id;
        $Resume = ResumeManager::where('uid', $User)->select('id')->first();

        $FullName = HomeController::GetUserData($User);

        $WorkExperienceData = [];
        $WorkExperienceData['resume_id'] = $Resume->id;
        $WorkExperienceData['full_name'] = $request->full_name;
        $WorkExperienceData['email'] = $request->email;
        $WorkExperienceData['phone'] = $request->phone;
        $WorkExperienceData['company_name'] = $request->company_name;
        $WorkExperienceData['cooperation_period'] = $request->cooperation_period;
        $WorkExperienceData['cooperation_type'] = $request->cooperation_type;
        $WorkExperienceData['linkedin'] = $request->linkedin;
        $WorkExperienceData['status'] = 'pending';
        $WorkExperienceData['key'] = HomeController::EncryptDecrypt($request->email . rand(1,9999999999999999), 'Secret Key 1400', 'encrypt');

        if (WorkExperience::create($WorkExperienceData)) {
            $content = '<p>همكار گرامی<br />با سلام</p><p> اینجانب ' . $FullName . ' برای تسهیل مسیر شغلی خود از شما درخواست توصیه نامه دارم، لطفا از طریق لینك زیر وارد پلتفرم شده و با تایید اطلاعات اولیه، من را برای همكاری های آینده به سازمان های متقاضی توصیه نمایید. </p><p>تجربه مثبت همكاری، سرمایه ای برای مسیر شغلی است.</p><p>آدرس لینك <br /><a href="' . 'https://' . env('APP_URL') . '/work-experience/' . $WorkExperienceData['key'] . '">تاپلیكنت؛ پلی برای متقاضیان برگزیده</a> <br/> ' . 'https://' . env('APP_URL') . '/work-experience/' . $WorkExperienceData['key'] . ' </p>';
            MailController::sendMail($request->email, 'درخواست ثبت تجربه همکاری از طرف ' . $FullName, $request->full_name, $content);

            return response()->json(['status' => 200]);
        }
    }

    /*
 * Store Work Experience
 * Route: /api/work-experience
 * POST
 * */
    public function delete(Request $request)
    {
        $User = auth()->user()->id;
        $Resume = ResumeManager::where('uid', $User)->select('uid')->first();
        if ($User === $Resume->uid) {
            $WorkExperience = WorkExperience::find($request->id);
            $WorkExperience->delete();
        } else {
            return response()->json(['status' => 401]);
        }

        return response()->json(['status' => 200]);
    }

    public function GetWorkExperience($slug)
    {

        $WorkExperience = WorkExperience::where('key', $slug)->select('company_name', 'full_name', 'experience_message', 'resume_id')->first();

        if ($WorkExperience) {
            $Resume = ResumeManager::select('uid')->find($WorkExperience->resume_id);
            $WorkExperience['resume_name'] = HomeController::GetUserData($Resume->uid);
            unset($WorkExperience['resume_id']);

            return response()->json(['status' => 200, 'WorkExperience' => $WorkExperience]);
        }else {
            return response()->json(['status' => 404]);
        }
    }

    public function SubmitWorkExperience(Request $request, $slug) {
        $WorkExperience = WorkExperience::where('key', $slug)->first();

        $WorkExperienceData = [];
        $WorkExperienceData['experience_message'] = $request->experience_message;
        $WorkExperienceData['status'] = 'active';

        if ($WorkExperience->update($WorkExperienceData)){
            return response()->json(['status' => 200]);
        }else {
            return response()->json(['status' => 'nok']);
        }
    }
}
