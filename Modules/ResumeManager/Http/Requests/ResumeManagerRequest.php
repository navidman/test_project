<?php

namespace Modules\ResumeManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResumeManagerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|regex:/^[\x{0600}-\x{065F}-\x{0670}-\x{06DF}-\{ }]*$/u',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|digits:11|numeric|regex:/^[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}$/',
            'job_position' => 'required',
            'level' => 'required',
            'birth_day' => 'required',
//            'sarbazi' => 'required',
            'cooperation_type' => 'required',
            'presence_type' => 'required',
            'salary' => 'required',
            'city' => 'required',
            'province' => 'required',
            'gender' => 'required',
            'access_resume' => 'required',
//            'specialty' => 'required',
            'skills' => 'required',
            'avatar' => 'mimes:jpeg,png,jpg|max:5000|dimensions:min_width=600,min_height=600',
            'resume_file' => 'mimes:pdf,zip|max:25000',
            'interview_file' => 'mimes:pdf,zip|max:25000',
            'recognition' => 'required',
            'confidence' => 'required',
            'expertise' => 'required',
            'personality' => 'required',
            'experience' => 'required',
            'software' => 'required',
            'organizational_behavior' => 'required',
            'passion' => 'required',
            'salary_rate' => 'required',
            'reason_adjustment' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => 'نام و نام خانوادگی',
            'email' => 'ایمیل',
            'phone' => 'شماره موبایل',
            'job_position' => 'عنوان شغلي',
            'level' => 'سطح ارشديت',
            'birth_day' => 'تاریخ تولد',
            'sarbazi' => 'وضعیت سربازی',
            'cooperation_type' => 'نوع همکاری',
            'salary' => 'حقوق درخواستی',
            'presence_type' => 'نوع حضور',
            'province' => 'استان',
            'city' => 'شهر',
            'gender' => 'جنسیت',
            'access_resume' => 'قابل نمایش',
            'specialty' => 'تخصص های فردی',
            'skills' => 'دانش و مهارت تخصصی',
            'avatar' => 'تصویر کارجو',
            'resume_file' => 'فایل رزومه شخصی',
            'recognition' => 'نحوه آشنایی',
            'confidence' => 'سطح اطمینان از تجربه پیشین',
            'expertise' => ' شایستگی های تخصصی',
            'personality' => ' شایستگی های روانشناختی',
            'experience' => ' میزان تجربه در شغل',
            'software' => ' مهارت های نرم افزاری',
            'organizational_behavior' => ' رفتار حرفه ای',
            'passion' => ' اشتیاق در شغل',
            'salary_rate' => ' حقوق و دستمزد',
            'reason_adjustment' => 'با این اوصاف چرا امکان همکاری فراهم نگردید؟',
            'interview_file' => 'فایل نتایج تجربه',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
