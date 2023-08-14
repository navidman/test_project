<?php

namespace Modules\SmsHandler\Http\Controllers;

use App\Models\MobileVerifyCode;
use Cryptommer\Smsir\Smsir;
use Illuminate\Routing\Controller;

class SmsHandlerController extends Controller
{
    public static function SmsVerify($Number)
    {
        $send = smsir::Send();

        $VerifyCode = rand(10000, 99999);
        $parameter = new \Cryptommer\Smsir\Objects\Parameters('CODE', $VerifyCode);
        $parameters = array($parameter);
        if ($send->Verify($Number, 100000, $parameters)) {
            return $VerifyCode;
        }else {
            return false;
        }
    }

    /*
     * Send Message By Patten
     * CallBack: True/False
     *
     * PatternCode = شناسه قالب شده
     * Number = شماره موبایل هدف
     * VariableCode = کد متغیر موجود در متن پیام
     * VariableCode = مقدار متغیر موجود در متن پیام
     *
     * */
    public static function SmsHandlerByPattern($PatternCode, $Number, $VariableCode, $VariableData) {
        $send = smsir::Send();

        $parameter = new \Cryptommer\Smsir\Objects\Parameters($VariableCode, $VariableData);
        $parameters = array($parameter);
        if ($send->Verify($Number, $PatternCode, $parameters)) {
            return true;
        }else {
            return false;
        }
    }
}
