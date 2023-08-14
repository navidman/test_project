<?php

namespace Modules\ResumeManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkExperienceRequest extends FormRequest
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
            'phone' =>'required|numeric',
            'company_name' =>'required',
            'cooperation_period' => 'required',
            'cooperation_type' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => 'نام و نام خانوادگی',
            'email' => 'ایمیل',
            'phone' => 'شماره تماس',
            'company_name' =>'نام شرکت',
            'cooperation_period' => 'مدت همکاری',
            'cooperation_type' => 'نوع همکاری',
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
