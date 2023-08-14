<?php

namespace Modules\ResumeManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumeManagerSuperAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required',
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
            'avatar' => 'mimes:jpeg,png,jpg',
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
