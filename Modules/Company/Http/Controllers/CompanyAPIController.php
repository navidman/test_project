<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Routing\Controller;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\ResumeIntroducer\Entities\ResumeIntroducer;
use Modules\Users\Entities\Users;

class CompanyAPIController extends Controller
{
    /*
     * Get Companies by Pagination
     * Route: /api/companies
     * Method: GET
     * */
    public function GetCompanies()
    {
        $Companies = Users::where('role', 'employer')->where('status', 'active')->where('avatar', '!=', null)->select('id', 'avatar', 'full_name', 'company_name_fa', 'company_name_en', 'company_activity', 'province', 'city')->orderBy('created_at', 'desc')->paginate(12);

        foreach ($Companies as $key => $item) {
            $Companies[$key]['avatar'] = HomeController::GetAvatar('92', '246', $item->avatar);
            $Companies[$key]['province'] = HomeController::selectState('number', $item->province);
            if ($item->company_activity && $item->company_activity !== 'null' && HomeController::GetCompanyCategory(json_decode($item->company_activity)[0])) {
                $Companies[$key]['company_activity'] = HomeController::GetCompanyCategory(json_decode($item->company_activity)[0])->title;
            } else {
                $Companies[$key]['company_activity'] = 'مشحص نشده است';
            }
        }

        return response()->json($Companies);
    }

    /*
     * Show Company Page
     * Route: /api/companies/{id}
     * GET
     * */
    public function CompanyPage($id)
    {
        $Company = Users::where('id', $id)->select('id', 'avatar', 'province', 'city', 'number_of_staff', 'website', 'biography', 'cover_image', 'job_group', 'company_name_fa', 'company_name_en')->first();

        $Company['avatar'] = HomeController::GetAvatar('84', '168', $Company->avatar);
        $Company['cover_image'] = HomeController::GetAvatar('1215', '2430', $Company->cover_image);
        $Company['province'] = HomeController::selectState('number', $Company->province);
        $Company['ads'] = EmploymentAdvertisement::where('uid', $Company->id)->count();
        $Company['resume'] = ResumeIntroducer::where('employment_id', $Company->id)->count();
        if ($Company->job_group && $Company->job_group != 'null') {
            $Company['job_group'] = json_decode($Company->job_group, true)[0];
        }
        if ($Company->company_activity) {
            $Company['company_activity'] = HomeController::GetCompanyCategory(json_decode($Company->company_activity)[0]) ? HomeController::GetCompanyCategory(json_decode($Company->company_activity)[0])->title : 'مشخص نشده';
        }

        return response()->json($Company);
    }
}
