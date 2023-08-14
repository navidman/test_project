<?php

namespace App\Http\Controllers;

class StateNameConvertController
{
    Public static function ConvertState($StateID) {
        $StateName = null;

        switch ($StateID) {
            case 1:
                $StateName = "تهران";
                break;
            case 2:
                $StateName = "گیلان";
                break;
            case 3:
                $StateName = "آذربایجان شرقی";
                break;
            case 4:
                $StateName = "خوزستان";
                break;
            case 5:
                $StateName = "فارس";
                break;
            case 6:
                $StateName = "اصفهان";
                break;
            case 7:
                $StateName = "خراسان رضوی";
                break;
            case 8:
                $StateName = "قزوین";
                break;
            case 9:
                $StateName = "سمنان";
                break;
            case 10:
                $StateName = "قم";
                break;
            case 11:
                $StateName = "مرکزی";
                break;
            case 12:
                $StateName = "زنجان";
                break;
            case 13:
                $StateName = "مازندران";
                break;
            case 14:
                $StateName = "گلستان";
                break;
            case 15:
                $StateName = "اردبیل";
                break;
            case 16:
                $StateName = "آذربایجان غربی";
                break;
            case 17:
                $StateName = "همدان";
                break;
            case 18:
                $StateName = "کردستان";
                break;
            case 19:
                $StateName = "کرمانشاه";
                break;
            case 20:
                $StateName = "لرستان";
                break;
            case 21:
                $StateName = "بوشهر";
                break;
            case 22:
                $StateName = "کرمان";
                break;
            case 23:
                $StateName = "هرمزگان";
                break;
            case 24:
                $StateName = "چهارمحال و بختیاری";
                break;
            case 25:
                $StateName = "یزد";
                break;
            case 26:
                $StateName = "سیستان و بلوچستان";
                break;
            case 27:
                $StateName = "ایلام";
                break;
            case 28:
                $StateName = "کهگلویه و بویراحمد";
                break;
            case 29:
                $StateName = "خراسان شمالی";
                break;
            case 30:
                $StateName = "خراسان جنوبی";
                break;
            case 31:
                $StateName = "البرز";
                break;
        }

        return $StateName;
    }
}
