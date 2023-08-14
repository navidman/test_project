<?php

namespace Modules\PartnerCompanies\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\PartnerCompanies\Entities\PartnerCompanies;
use Modules\Users\Entities\Users;

class PartnerCompaniesController extends Controller
{
    /*
     * Show Partner Companies List
     * Route: /api/partner-companies
     * GET
     * */
    public function PartnerCompanies()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $PartnerCompanies = PartnerCompanies::where('from_id', $User)->orWhere('to_id', $User)->get()->all();

        foreach ($PartnerCompanies as $key => $item) {
            if ($item->from_id === $User) {
                $PartnerCompanies[$key]['partner_id'] = $item->to_id;
                $PartnerCompanies[$key]['avatar'] = HomeController::GetAvatar('46', '92', HomeController::GetUserData($item->to_id, 'avatar'));
                $PartnerCompanies[$key]['company_name'] = HomeController::GetUserData($item->to_id, 'company_name');
                $PartnerCompanies[$key]['owner'] = 'me';
            } else {
                $PartnerCompanies[$key]['partner_id'] = $item->from_id;
                $PartnerCompanies[$key]['avatar'] = HomeController::GetAvatar('46', '92', HomeController::GetUserData($item->from_id, 'avatar'));
                $PartnerCompanies[$key]['company_name'] = HomeController::GetUserData($item->from_id, 'company_name');
                $PartnerCompanies[$key]['owner'] = 'another';
                if ($item->status === 'reject') {
                    unset($PartnerCompanies[$key]);
                }
            }
        }

        return response()->json($PartnerCompanies);
    }


    /*
     * Get Companies
     * Route: /api/partner/get-company-list
     * GET
     * */
    public function GetCompanyList()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $PartnerCompany = PartnerCompanies::where('from_id', $User)->orWhere('to_id', $User)->get()->all();

        $PartnerCompanyIDs = [$User];
        if (count($PartnerCompany)) {
            foreach ($PartnerCompany as $item) {
                array_push($PartnerCompanyIDs, $item->to_id);
                array_push($PartnerCompanyIDs, $item->from_id);
            }

            $PartnerCompanyIDs = array_unique($PartnerCompanyIDs);
        }

        $Companies = Users::where('role', 'employer')->where('status', 'active')->where('parent_id', null)->whereNotIn('id', $PartnerCompanyIDs ? $PartnerCompanyIDs : [])->select('id', 'company_name_fa')->get()->all();

        return response()->json($Companies);
    }


    /*
     * Add Partner Company
     * Route: /api/add-partner-company
     * POST
     * */
    public function AddPartnerCompany(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $CheckCompanyExists = PartnerCompanies::where('from_id', $request->id)->where('to_id', $request->id)->count();

        if ($CheckCompanyExists == 0) {
            $PartnerCompany = [];
            $PartnerCompany['from_id'] = $User;
            $PartnerCompany['to_id'] = $request->id;
            $PartnerCompany['revision'] = 0;
            $PartnerCompany['active'] = 'true';
            $PartnerCompany['status'] = 'pending';

            if (PartnerCompanies::create($PartnerCompany)) {
                return response()->json(['status' => 'ok']);
            } else {
                return response()->json(['status' => 'nok']);
            }
        } else {
            return response()->json(['status' => 'exists']);
        }
    }


    /*
     * Change Partner Active Toggle
     * Route: /api/change-partner-active
     * POST
     * */
    public function ChangePartnerActiveToggle(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Partner = PartnerCompanies::find($request->id);
        if ($Partner->from_id === $User || $Partner->to_id === $User) {
            if ($Partner->active == 'true') {
                $Partner->update([
                    'active' => 'false'
                ]);
            } else {
                $Partner->update([
                    'active' => 'true'
                ]);
            }
        }
    }


    /*
      * Delete Partner Request
      * Route: /api/delete-partner
      * POST
      * */
    public function DeletePartnerRequest(Request $request)
    {
        if (Auth::user()->parent_id) {
            $UserID = Auth::user()->parent_id;
        } else {
            $UserID = auth()->user()->id;
        }

        $PartnerCompany = PartnerCompanies::find($request->id);
        if ($PartnerCompany->from_id === $UserID || $PartnerCompany->to_id === $UserID) {
            $PartnerCompany->delete();
        }
    }


    /*
     * Change Status Partner
     * Route: /api/change-status-partner
     * POST
     * */
    public function ChangeStatusPartner(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Partner = PartnerCompanies::find($request->id);
        if ($Partner->to_id === $User) {
            if ($Partner->status == 'pending') {
                if ($request->status === 'accept') {
                    $Partner->update([
                        'status' => 'accept'
                    ]);
                } elseif ($request->status === 'reject') {
                    $Partner->update([
                        'status' => 'reject'
                    ]);
                }
            }
        } elseif ($Partner->from_id === $User) {
            if ($Partner->status == 'reject') {
                if ($request->status === 'revision') {
                    $Partner->update([
                        'status' => 'pending',
                        'revision' => $Partner->revision + 1
                    ]);
                }
            }
        }
    }
}
