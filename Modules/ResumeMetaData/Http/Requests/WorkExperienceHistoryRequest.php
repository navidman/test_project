<?php

namespace Modules\ResumeMetaData\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkExperienceHistoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required',
            'job_title' => 'required',
            'cooperation_type' => 'required',
            'date' => 'required',
            'to_date' => ['required', 'required_with:date',
                function (string $attribute, mixed $value, $fail) {
                    if ($value !== true) {
                        if ($value >= $this->date) {
                        } else {
                            $fail('تاریخ پایان همکاری باید بیشتر یا مساوی با تاریخ شروع همکاری باشد.');
                        }
                    }
                },
            ]
        ];
    }

    public function attributes()
    {
        return [
            'company_name' => 'نام شرکت',
            'job_title' => 'عنوان شغلی',
            'cooperation_type' => 'نوع همکاری',
            'date' => 'تاریخ شروع',
            'to_date' => 'تاریخ پایان همکاری',
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
