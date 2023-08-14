<?php

namespace Modules\Payments\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Payments\Entities\Payments;
use Modules\Payments\Entities\Wallet;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class WalletController extends Controller
{
    /*
     * Increase wallet balance
     * Route: /api/payments/charging-wallet
     * POST
     * */
    public function ChargingWallet(Request $request)
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        switch ($request->amount) {
            case ($request->amount <= 50000):
                return response()->json(['status' => 'min']);
            case ($request->amount >= 50000000):
                return response()->json(['status' => 'max']);
        }

        $PaymentsData['uid'] = $User;
        $PaymentsData['title'] = 'افزایش موجودی کیف پول';
        $PaymentsData['product_type'] = 'wallet';
        $PaymentsData['amount'] = $request->amount;
        $PaymentsData['payment_amount'] = $request->amount;
        $PaymentsData['gateway'] = 'زرین پال';
        $PaymentsData['currency'] = 'تومان';
        $PaymentsData['status'] = 0;

        if ($PaymentID = Payments::create($PaymentsData)) {
            $invoice = (new Invoice())->amount(intval($request->amount));
            return Payment::callbackUrl(route('result', $PaymentID->id))->purchase($invoice, function ($driver, $transactionId) {
            })->pay()->toJson();
        }
    }

    /*
     * Callback Payment Gateway
     * POST
     * */
    public function result(Request $request, Payments $PaymentID)
    {
        try {
            $receipt = Payment::amount(intval($PaymentID->payment_amount))->transactionId($request->Authority)->verify();

            $Payments = Payments::find($PaymentID->id);
            $PaymentsData['transaction_id'] = $receipt->getReferenceId();
            $PaymentsData['status'] = 1;

            $Payments->update($PaymentsData);

            $Wallet = Wallet::where('uid', $Payments->uid)->first();
            $Amount = HomeController::TopliValue($Payments->payment_amount);

            if ($Wallet->update(['topli' => $Wallet->topli + $Amount])) {
                return redirect('https://' . env('APP_URL') . '/panel/wallet?status=200');
            }
        } catch (InvalidPaymentException $exception) {
            return redirect('https://' . env('APP_URL') . '/panel/wallet?status=nok');
            echo $exception->getMessage();
        }
    }
}
