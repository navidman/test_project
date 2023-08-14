<?php

namespace Modules\Payments\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Payments\Entities\Wallet;
use Modules\Payments\Entities\Withdrawal;
use Modules\Payments\Http\Requests\WithdrawalRequest;
use Modules\Users\Entities\Users;

class WithdrawalController extends Controller
{
    public function index()
    {
        $Withdrawal = Withdrawal::orderBy('created_at', 'desc')->paginate(20);

        if ($Withdrawal) {
            foreach ($Withdrawal as $key => $item) {
                $Withdrawal[$key]['user'] = ['name' => HomeController::GetUserData($item->user_id)];
            }
        }

        return view('payments::withdrawal.index', compact('Withdrawal'));
    }

    public function edit($id)
    {
        $Withdrawal = Withdrawal::find($id);
        $Withdrawal['balance'] = Wallet::where('uid', $Withdrawal->user_id)->first()->topli_score * 1000;
        $Withdrawal['user'] = ['name' => HomeController::GetUserData($Withdrawal->user_id)];

        $Data = [
            'Withdrawal',
        ];

        return view('payments::withdrawal.edit', compact($Data));
    }

    public function update(Request $request, $id)
    {
        $Withdrawal = Withdrawal::find($id);
        $WithdrawalData = $request->all();

        if ($Withdrawal->update($WithdrawalData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'وضعیت بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/withdrawal')->with('notification', [
                'class' => 'danger',
                'message' => 'بروزرسانی با خطا روبرو شد'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        foreach ($request->delete_item as $key => $item) {
            Withdrawal::where('id', $key)->delete();
        }

        return redirect('/dashboard/withdrawal')->with('notification', [
            'class' => 'withdrawal',
            'message' => 'درخواست مورد نظر حذف شد'
        ]);
    }


    public function get()
    {
        $Data = [];
        $Data['shaba'] = Users::find(auth('sanctum')->user()->id)->shaba;
        $Data['balance'] = Wallet::where('uid', auth('sanctum')->user()->id)->first()->topli_score * 1000;

        return response()->json(['getData' => $Data]);
    }

    public function store(WithdrawalRequest $request)
    {
        $Shaba = Users::find(auth('sanctum')->user()->id)->shaba;
        $Balance = Wallet::where('uid', auth('sanctum')->user()->id)->first()->topli_score * 1000;

        if ($Shaba) {
            if ($request->amount > 50000) {
                if ($Balance >= intval($request->amount)) {
                    $WithdrawalData = [];
                    $WithdrawalData['user_id'] = auth('sanctum')->user()->id;
                    $WithdrawalData['shaba'] = $Shaba;
                    $WithdrawalData['amount'] = $request->amount;
                    $WithdrawalData['status'] = 'new';
                    if ($Withdrawal = Withdrawal::create($WithdrawalData)) {
                        return response()->json(['status' => 200, 'getData' => $Withdrawal]);
                    }
                } else {
                    return response()->json(['status' => 'balance_not_enough']);
                }
            } else {
                return response()->json(['status' => 'balance_err']);
            }
        } else {
            return response()->json(['status' => 'shaba_err']);
        }
    }

    public function history()
    {
        return response()->json(['getData' => Withdrawal::where('user_id', auth('sanctum')->user()->id)->orderBy('created_at', 'desc')->get()]);
    }
}
