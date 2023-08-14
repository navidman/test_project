<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementCategory;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementProficiency;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\ResumeIntroducer\Entities\ResumeIntroducer;
use Modules\ResumeManager\Entities\ResumeConfirmReject;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\Users\Entities\Users;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the Index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('site.pages.index');
    }

    /* Short text */
    public static function TruncateString($str, $chars, $to_space, $replacement = "...")
    {
        if ($chars > strlen($str)) return $str;

        $str = substr($str, 0, $chars);
        $space_pos = strrpos($str, " ");
        if ($to_space && $space_pos >= 0)
            $str = substr($str, 0, strrpos($str, " "));

        return ($str . $replacement);
    }

    /* Short text */
    public static function Censor($string)
    {

        $replacement = str_repeat(' * ', rand(6, 9));
        $string = preg_replace("/\d/u", ' ', $string);
//        return $string;
        return substr_replace($string, $replacement, 4, -4);
    }

    /* Convert Salary */
    public static function ConvertSalary($salary)
    {
        $CallBack = 0;
        switch ($salary) {
            case 'adaptive' :
                $CallBack = 'توافقی';
                break;
            case 'basic_salary' :
                $CallBack = 'حقوق پایه (وزارت کار)';
                break;
            case '4-6' :
                $CallBack = 'از ۴ تا ۶ میلیون تومان';
                break;
            case '6-8' :
                $CallBack = 'از ۶ تا ۸ میلیون تومان';
                break;
            case '8-10' :
                $CallBack = 'از ۸ تا ۱۰ میلیون تومان';
                break;
            case '10-12' :
                $CallBack = 'از ۱۰ تا ۱۲ میلیون تومان';
                break;
            case '12-14' :
                $CallBack = 'از ۱۲ تا ۱۴ میلیون تومان';
                break;
            case '14-16' :
                $CallBack = 'از ۱۴ تا ۱۶ میلیون تومان';
                break;
            case '16-20' :
                $CallBack = 'از ۱۶ تا ۲۰ میلیون تومان';
                break;
            case '20-25' :
                $CallBack = 'از ۲۰ تا ۲۵ میلیون تومان';
                break;
            case '25-30' :
                $CallBack = 'از ۲۵ تا ۳۰ میلیون تومان';
                break;
            case '30-35' :
                $CallBack = 'از ۳۰ تا ۳۵ میلیون تومان';
                break;
            case '35-40' :
                $CallBack = 'از ۳۵ تا ۴۰ میلیون تومان';
                break;
            case '40-45' :
                $CallBack = 'از ۴۰ تا ۴۵ میلیون تومان';
                break;
            case '45-50' :
                $CallBack = 'از ۴۵ تا ۵۰ میلیون تومان';
                break;
            case 'more_than_50' :
                $CallBack = 'بیش از ۵۰ میلیون تومان';
                break;
        }

        return $CallBack;
    }

    /* Convert Gender */
    public static function ConvertGender($gender)
    {
        $CallBack = 0;
        switch ($gender) {
            case 'male' :
                $CallBack = 'آقا';
                break;
            case 'female' :
                $CallBack = 'خانم';
                break;
        }

        return $CallBack;
    }

    /* Convert Support Status */
    public static function ConvertSupportStatus($status)
    {
        $CallBack = 0;
        switch ($status) {
            case 'new' :
                $CallBack = 'در انتظار پاسخ';
                break;
            case 'replied' :
                $CallBack = 'پاسخ داده شده';
                break;
            case 'closed' :
                $CallBack = 'موضوع بسته شده';
                break;
            case 'pending' :
                $CallBack = 'در انتظار پاسخ';
                break;
        }

        return $CallBack;
    }

    /* Convert Support Status */
    public static function ConvertSupportPriority($priority)
    {
        $CallBack = 0;
        switch ($priority) {
            case 'high' :
                $CallBack = 'زیاد';
                break;
            case 'medium' :
                $CallBack = 'متوسط';
                break;
            case 'low' :
                $CallBack = 'کم';
                break;
        }

        return $CallBack;
    }

    /* State Code */
    public static function selectState($type = 'name', $state)
    {
        $CallBack = 0;
        if ($type == 'name') {
            switch ($state) {
                case 'تهران' :
                    $CallBack = 1;
                    break;
                case 'گیلان' :
                    $CallBack = 2;
                    break;
                case 'آذربایجان شرقی' :
                    $CallBack = 3;
                    break;
                case 'خوزستان' :
                    $CallBack = 4;
                    break;
                case 'فارس' :
                    $CallBack = 5;
                    break;
                case 'اصفهان' :
                    $CallBack = 6;
                    break;
                case 'خراسان رضوی' :
                    $CallBack = 7;
                    break;
                case 'قزوین' :
                    $CallBack = 8;
                    break;
                case 'سمنان' :
                    $CallBack = 9;
                    break;
                case 'قم' :
                    $CallBack = 10;
                    break;
                case 'مرکزی' :
                    $CallBack = 11;
                    break;
                case 'زنجان' :
                    $CallBack = 12;
                    break;
                case 'مازندران' :
                    $CallBack = 13;
                    break;
                case 'گلستان' :
                    $CallBack = 14;
                    break;
                case 'اردبیل' :
                    $CallBack = 15;
                    break;
                case 'آذربایجان غربی' :
                    $CallBack = 16;
                    break;
                case 'همدان' :
                    $CallBack = 17;
                    break;
                case 'کردستان' :
                    $CallBack = 18;
                    break;
                case 'کرمانشاه' :
                    $CallBack = 19;
                    break;
                case 'لرستان' :
                    $CallBack = 20;
                    break;
                case 'بوشهر' :
                    $CallBack = 21;
                    break;
                case 'کرمان' :
                    $CallBack = 22;
                    break;
                case 'هرمزگان' :
                    $CallBack = 23;
                    break;
                case 'چهارمحال و بختیاری' :
                    $CallBack = 24;
                    break;
                case 'یزد' :
                    $CallBack = 25;
                    break;
                case 'سیستان و بلوچستان' :
                    $CallBack = 26;
                    break;
                case 'ایلام' :
                    $CallBack = 27;
                    break;
                case 'کهگلویه و بویراحمد' :
                    $CallBack = 28;
                    break;
                case 'خراسان شمالی' :
                    $CallBack = 29;
                    break;
                case 'خراسان جنوبی' :
                    $CallBack = 30;
                    break;
                case 'البرز' :
                    $CallBack = 31;
                    break;
            }
        } elseif ($type == 'number') {
            switch ($state) {
                case 1 :
                    $CallBack = 'تهران';
                    break;
                case 2 :
                    $CallBack = 'گیلان';
                    break;
                case 3 :
                    $CallBack = 'آذربایجان شرقی';
                    break;
                case 4 :
                    $CallBack = 'خوزستان';
                    break;
                case 5 :
                    $CallBack = 'فارس';
                    break;
                case 6 :
                    $CallBack = 'اصفهان';
                    break;
                case 7 :
                    $CallBack = 'خراسان رضوی';
                    break;
                case 8 :
                    $CallBack = 'قزوین';
                    break;
                case 9 :
                    $CallBack = 'سمنان';
                    break;
                case 10 :
                    $CallBack = 'قم';
                    break;
                case 11 :
                    $CallBack = 'مرکزی';
                    break;
                case 12 :
                    $CallBack = 'زنجان';
                    break;
                case 13 :
                    $CallBack = 'مازندران';
                    break;
                case 14 :
                    $CallBack = 'گلستان';
                    break;
                case 15 :
                    $CallBack = 'اردبیل';
                    break;
                case 16 :
                    $CallBack = 'آذربایجان غربی';
                    break;
                case 17 :
                    $CallBack = 'همدان';
                    break;
                case 18 :
                    $CallBack = 'کردستان';
                    break;
                case 19 :
                    $CallBack = 'کرمانشاه';
                    break;
                case 20 :
                    $CallBack = 'لرستان';
                    break;
                case 21 :
                    $CallBack = 'بوشهر';
                    break;
                case 22 :
                    $CallBack = 'کرمان';
                    break;
                case 23 :
                    $CallBack = 'هرمزگان';
                    break;
                case 24 :
                    $CallBack = 'چهارمحال و بختیاری';
                    break;
                case 25 :
                    $CallBack = 'یزد';
                    break;
                case 26 :
                    $CallBack = 'سیستان و بلوچستان';
                    break;
                case 27 :
                    $CallBack = 'ایلام';
                    break;
                case 28 :
                    $CallBack = 'کهگلویه و بویراحمد';
                    break;
                case 29 :
                    $CallBack = 'خراسان شمالی';
                    break;
                case 30 :
                    $CallBack = 'خراسان جنوبی';
                    break;
                case 31 :
                    $CallBack = 'البرز';
                    break;
            }
        }

        return $CallBack;
    }

    /* Get User Full Name */
    public static function GetUserData($id, $data = 'name')
    {
        $User = User::find($id);

        $CallBack = '';

        switch ($data) {
            case 'name':
                $CallBack = $User->full_name;
                break;
            case 'email':
                $CallBack = $User->email;
                break;
            case 'province':
                $CallBack = HomeController::selectState($User->province);
                break;
            case 'city':
                $CallBack = $User->city;
                break;
            case 'company_name':
                $CallBack = $User->company_name_fa;
                break;
            case 'gender_org':
                $CallBack = $User->gender;
                break;
            case 'gender':
                $CallBack = HomeController::ConvertGender($User->gender);
                break;
            case 'avatar':
                $CallBack = $User->avatar;
                break;
            case 'role':
                $CallBack = $User->role;
                break;
        }

        return $CallBack;
    }

    /* Get Avatar */
    public static function GetAvatar($size, $retineSize, $id = '')
    {
        $Avatar['path'] = '';
        $Avatar['pathX2'] = '';

        if ($id) {
            $UserAvatar = FileLibrary::find($id);

            if (isset($UserAvatar)) {
                if ($UserAvatar->extension != 'svg') {
                    $Avatar['path'] = url('storage/' . $UserAvatar->path . $size . '/' . $UserAvatar->file_name);
                    $Avatar['pathX2'] = url('storage/' . $UserAvatar->path . $retineSize . '/' . $UserAvatar->file_name);
                } else {
                    $Avatar['path'] = url('storage/' . $UserAvatar->path . 'full/' . $UserAvatar->file_name);
                }
            }
        }

        return $Avatar;
    }

    /* Avatar Generation */
    public static function AvatarGenerate($gender)
    {
        $Avatar = url('storage/app/public/avatars/' . $gender . '/' . rand(1, 3) . '.png');

        return $Avatar;
    }

    /* Get Company Category */
    public static function GetCompanyCategory($cat)
    {
        $CallBack = null;

        if ($cat && EmploymentAdvertisementCategory::find($cat)) {
            $CallBack = EmploymentAdvertisementCategory::find($cat);
        } else {
            $CallBack = null;
        }

        return $CallBack;
    }

    /* Get Company Proficiency */
    public static function GetCompanyProficiency($Proficiency)
    {
        $CallBack = null;

        if ($Proficiency) {
            $CallBack = EmploymentAdvertisementProficiency::find($Proficiency);
        }

        return $CallBack;
    }

    /* Check Confidence */
    public static function CheckConfidence($id)
    {
        $ResumeIntroducer = ResumeIntroducer::where('resume_id', $id)->where('status', 'active')->select('confidence')->get()->all();
        $Confidence = false;

        foreach ($ResumeIntroducer as $item) {
            if ($item->confidence == 'چک شده و کاملا مثبت' || $item->confidence == 'مثبت ولی می تواند بیشتر چک شود') {
                $Confidence = true;
            }
        }

        return $Confidence;
    }

    /* Check Resume Confirmed */
    public static function CheckResumeConfirmed($ResumeID, $UserID = null)
    {
        if ($UserID) {
            $User = $UserID;
        } else {
            if (Auth::user()->parent_id) {
                $User = Auth::user()->parent_id;
            } else {
                $User = auth()->user()->id;
            }
        }

        $Callback = false;
        if (ResumeConfirmReject::where('resume_id', $ResumeID)->where('employer_id', $User)->count()) {
            $Callback = true;
        }

        return $Callback;
    }

    /* Background Level */
    public static function BackgroundLevel($level)
    {
        return match ($level) {
            'مدیر عامل' => '#ff9600',
            'قائم مقام' => '#FE5434',
            'معاونت' => '#D37C56',
            'مدیر' => '#FFC700',
            'رئیس / سرپرست' => '#7F92AB',
            'کارشناس ارشد / کارشناس مسئول' => '#7F92AB',
            'کارشناس' => '#004AB8',
            'کارمند' => '#004AB8',
            default => null,
        };
    }

    /* Calculate Topli By Level */
    public static function CalculateTopliByLevel($level, $percentage = 100)
    {
        return match ($level) {
            'مدیر عامل' => ($percentage * 2000) / 100,
            'قائم مقام' => ($percentage * 1000) / 100,
            'معاونت' => ($percentage * 1000) / 100,
            'مدیر' => ($percentage * 200) / 100,
            'رئیس / سرپرست' => ($percentage * 100) / 100,
            'کارشناس ارشد / کارشناس مسئول' => ($percentage * 100) / 100,
            'کارشناس' => ($percentage * 75) / 100,
            'کارمند' => ($percentage * 30) / 100,
            default => 0,
        };
    }

    /* Topli Value */
    public static function TopliValue($Amount)
    {
        return $Amount / 10000;
    }

    /* Check Resume Percentage */
    public static function CheckResumePercentage($ResumeID)
    {
        $CallBack = 0;

        $Resume = ResumeManager::find($ResumeID);
        $Introducer = ResumeIntroducer::where('resume_id', $ResumeID)->first();
        $User = Users::find($Resume->uid);

        if ($Resume) {
            /* Resume */
            if ($User->full_name != '') {
                $CallBack += 5.5;
            }
            if ($User->email != '') {
                $CallBack += 5.5;
            }
            if ($User->phone != '') {
                $CallBack += 5.5;
            }
            if ($Resume->job_position != '') {
                $CallBack += 5.5;
            }
            if ($Resume->level != '') {
                $CallBack += 5.5;
            }
            if ($User->province != '') {
                $CallBack += 5.5;
            }
            if ($User->city != '') {
                $CallBack += 5.5;
            }
            if ($User->gender != '') {
                $CallBack += 5.5;
            }
//            if ($Resume->specialty != '' && $Resume->specialty != null) {
//                $CallBack += 5.5;
//            }
            if ($Resume->access_resume != '') {
                $CallBack += 5.5;
            }
            if ($Resume->skills != '') {
                $CallBack += 11;
            }
            if ($Resume->salary != '') {
                $CallBack += 5.5;
            }
            if ($Resume->birth_day != '') {
                $CallBack += 5.5;
            }
            if ($Resume->sarbazi != '') {
                $CallBack += 5.5;
            }
            if ($Resume->cooperation_type != '') {
                $CallBack += 5.5;
            }
            if ($Resume->presence_type != '') {
                $CallBack += 6;
            }
            if ($Resume->resume_file != '') {
                $CallBack += 5.5;
            }
            if ($User->avatar != '') {
                $CallBack += 5.5;
            }

            /* Introducer */
            if (isset($Introducer->confidence) && $Introducer->confidence != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->expertise) && $Introducer->expertise != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->personality) && $Introducer->personality != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->experience) && $Introducer->experience != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->software) && $Introducer->software != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->organizational_behavior) && $Introducer->organizational_behavior != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->passion) && $Introducer->passion != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->salary_rate) && $Introducer->salary_rate != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->reason_adjustment) && $Introducer->reason_adjustment != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->comment_employment) && $Introducer->comment_employment != '') {
                $CallBack += 3;
            }
            if (isset($Introducer->expert_opinion) && $Introducer->expert_opinion != '') {
                $CallBack += 3;
            }
            if (isset($Introducer->interview_file) && $Introducer->interview_file != '') {
                $CallBack += 4;
            }
            if (isset($Introducer->voice) && $Introducer->voice != '') {
                $CallBack += 4;
            }
        }

        return round($CallBack);
    }

    public static function EncryptDecrypt($String, $SecretKey, $type = 'encrypt')
    {
        $Callback = '';

        function encrypt($string, $key)
        {
            $result = '';
            for ($i = 0; $i < strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                $char = chr(ord($char) + ord($keychar));
                $result .= $char;
            }

            return base64_encode(base64_encode(base64_encode(base64_encode($result))));
        }

        function decrypt($string, $key)
        {
            $result = '';
            $string = base64_decode(base64_decode(base64_decode(base64_decode($string))));

            for ($i = 0; $i < strlen($string); $i++) {
                $char = substr($string, $i, 1);
                $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                $char = chr(ord($char) - ord($keychar));
                $result .= $char;
            }

            return $result;
        }

        switch ($type) {
            case 'encrypt' :
                $Callback = encrypt($String, $SecretKey);
                break;
            case 'decrypt' :
                $Callback = decrypt($String, $SecretKey);
                break;
        }

        return $Callback;
    }

    public static function ConvertDate($Date, $type)
    {
        $now = new \DateTime();
        $ago = new \DateTime($Date);
        $diff = $now->diff($ago);

        return match ($type) {
            'day' => $diff->format('%a'),
            'month' => $diff->format('%M'),
            'year' => $diff->format('%Y'),
        };
    }
}
