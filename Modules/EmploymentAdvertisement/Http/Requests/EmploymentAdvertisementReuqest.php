<?php

namespace Modules\EmploymentAdvertisement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmploymentAdvertisementReuqest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'cat' => 'required',
            'proficiency' => 'required',
            'city' => 'required',
//            'personal_proficiency' => 'required',
            'cooperation_type' => 'required',
            'minimum_salary' => 'required',
            'gender' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان',
            'cat' => 'گروه شغلی',
            'proficiency' => 'گروه شغلی',
            'city' => 'شهر',
//            'personal_proficiency' => 'تخصص های فردی',
            'cooperation_type' => 'نوع همکاری',
            'minimum_salary' => 'حداقل حقوق',
            'gender' => 'جنسیت',
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
