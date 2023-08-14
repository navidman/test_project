<?php

namespace Modules\Payments\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Discount\Http\Controllers\DiscountController;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\OrderManagement\Entities\OrderManagement;
use Modules\Payments\Entities\Payments;
use Modules\Payments\Entities\Wallet;
use Modules\Product\Entities\Product;
use Modules\ResumeIntroducer\Entities\ResumeIntroducer;
use Modules\ResumeManager\Entities\PurchasedResumes;
use Modules\ResumeManager\Entities\ResumeManager;

class PaymentsController extends Controller
{
    /*
     * Purchase Resume
     * Route: /api/payments/purchase
     * POST
     * */
    public function purchase(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->parent_id) {
                $User = Auth::user()->parent_id;
            } else {
                $User = auth()->user()->id;
            }

            $MyWallet = Wallet::where('uid', $User)->first();
            $MyWalletInventory = $MyWallet->topli + $MyWallet->topli_score;
        } else {
            $MyWalletInventory = 0;
        }

        $ids = explode(',', $request->ids);

        $Topli = 0;
        foreach ($ids as $id) {
            $PurchasedResumes = PurchasedResumes::where('buyer_id', $User)->where('resume_id', $id)->select('resume_id')->get()->all();
            $PurchasedResumesIDs = [];
            if (count($PurchasedResumes)) {
                foreach ($PurchasedResumes as $item) {
                    array_push($PurchasedResumesIDs, $item->resume_id);
                }
            }
            if (!$PurchasedResumesIDs == $id) {
                $ResumeItem = ResumeManager::find($id);
                $Topli += HomeController::CalculateTopliByLevel($ResumeItem->level, 100);

//            /* یک یا چند رزومه قبل از پرداخت فروخته شدن */
//            if ($ResumeItem->job_status === 'sold') {
//                return response()->json([
//                    'status' => 'sold',
//                    'sold' => $id
//                ]);
//            }

                /* موجودی کافی نیست */
                /* Discount */
                if ($Topli - ((70 / 100) * $Topli) > $MyWalletInventory) {
                    return response()->json([
                        'status' => 'inventory'
                    ]);
                }
            }
        }

        /* Discount */
        $Topli = $Topli - ((70 / 100) * $Topli);

        foreach ($ids as $ResumeID) {
            $Resume = ResumeManager::find($ResumeID);
//            $Resume->update(['job_status' => 'sold']);
            $ResumeIntroducer = ResumeIntroducer::where('resume_id', $Resume->id)->where('status', 'active')->get();
            PurchasedResumes::create([
                'buyer_id' => $User,
                'resume_id' => $ResumeID,
                /* Discount */
                'amount' => HomeController::CalculateTopliByLevel($Resume->level, 30)
            ]);

            foreach ($ResumeIntroducer as $ItemIntroducer) {
                $ItemIntroducer->update(['status' => 'sold']);

                /* Cash Back Introducer */
                $Wallet = Wallet::where('uid', $ItemIntroducer->employment_id)->first();
                $TopliScore = HomeController::CalculateTopliByLevel($Resume->level, 30);
                OrderManagement::create([
                    'uid' => $ItemIntroducer->employment_id,
                    'type' => 'receive',
                    'title' => 'رزومه پلاس ' . HomeController::GetUserData($ItemIntroducer->job_seeker_id, 'name') . ' فروخته شد.',
                    'object' => 'فروش رزومه +',
                    'score' => $TopliScore
                ]);


                $Wallet->update([
                    'topli_score' => $Wallet->topli_score + $TopliScore
                ]);
            }
        }

        OrderManagement::create([
            'uid' => $User,
            'title' => 'شما ' . count($ids) . ' رزومه پلاس خریداری کرده اید',
            'object' => 'خرید رزومه',
            'score' => $Topli,
            'type' => 'pay'
        ]);

        /* Cost Topli */
        if ($MyWallet->topli_score < $Topli) {
            $Topli -= $MyWallet->topli_score;
            $MyWallet->update(['topli' => $MyWallet->topli - $Topli, 'topli_score' => 0]);
        } else {
            $MyWallet->update(['topli_score' => $MyWallet->topli_score - $Topli]);
        }

        /* After Purchase Get Resume Download File */
        $Resume = [];
        foreach ($ids as $id) {
            $ResumeItem = ResumeManager::where('status', 'accept_job_seeker')->with(
                [
                    'user_tbl' => function ($query) {
                        $query->select('id', 'full_name', 'avatar');
                    }
                ]
            )->select('id', 'uid', 'level', 'job_position', 'job_status', 'resume_file')->find($id);

            array_push($Resume, $ResumeItem);
        }

        if ($Resume) {
            foreach ($Resume as $key => $item) {
                $ResumeFile = FileLibrary::find($item->resume_file);
                $Resume[$key]['resume_file'] = $ResumeFile ? url('storage/' . $ResumeFile->path . '/' . $ResumeFile->file_name) : '';
                $Resume[$key]['full_name'] = $item->user_tbl->full_name;
                $Resume[$key]['avatar'] = HomeController::GetAvatar('46', '92', $item->user_tbl->avatar);
                unset($Resume[$key]['uid']);
                unset($Resume[$key]['user_tbl']);
            }
        }

        return response()->json([$Resume, 'status' => 200]);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $Payments = Payments::where('transaction_id', 'like', '%' . $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $Payments = Payments::orderBy('created_at', 'desc')->paginate(20);
        }

        return view('payments::index', compact('Payments'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Payments = Payments::find($id);
        $Payments->update(['viewed' => 1]);
        $Payments->order_meta = json_decode($Payments->order_meta, true);

        $Data = [
            'Payments'
        ];

        return view('payments::edit', compact($Data));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        foreach ($request->delete_item as $key => $item) {
            Payments::where('id', $key)->delete();
        }

        return redirect('/dashboard/payments')->with('notification', [
            'class' => 'success',
            'message' => 'صورتحساب های مورد نظر حذف شد'
        ]);
    }
}
