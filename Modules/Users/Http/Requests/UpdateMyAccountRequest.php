<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMyAccountRequest extends FormRequest
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
            'organization_level' => 'required',
            'email' => 'required|nullable|email|unique:users,email,'.$this->user()->id,
            'phone' => 'required|numeric|unique:users,phone,'.$this->user()->id,
            'company_name_fa' => 'required',
            'company_name_en' => 'required',
            'economic_code' => 'required',
            'organization_phone' => 'required|numeric',
            'province' => 'required',
            'city' => 'required',
            'website' => ['required','regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => 'نام و نام خانوادگی',
            'organization_level' => 'سمت سازمانی',
            'email' => 'آدرس ایمیل',
            'phone' => 'موبایل',
            'company_name_fa' => 'نام شرکت',
            'company_name_en' => 'نام انگلیسی شرکت',
            'economic_code' => 'کد اقتصادی',
            'organization_phone' => 'تلفن سازمانی',
            'province' => 'استان',
            'city' => 'شهر',
            'website' => 'وب سایت',
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
