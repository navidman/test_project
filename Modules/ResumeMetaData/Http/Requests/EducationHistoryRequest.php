<?php

namespace Modules\ResumeMetaData\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationHistoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'field_of_study' => 'required',
            'grade' => 'required',
            'university' => 'required',
            'date' => 'required',
            'to_date' => ['required', 'required_with:date',
                function (string $attribute, mixed $value, $fail) {
                    if ($value !== true) {
                        if ($value >= $this->date) {
                        } else {
                            $fail('تاریخ پایان تحصیل باید بیشتر یا مساوی با تاریخ شروع تحصیل باشد.');
                        }
                    }
                },
            ]
        ];
    }

    public function attributes()
    {
        return [
            'field_of_study' => 'رشته تحصیلی',
            'grade' => 'مقطع تحصیلی',
            'university' => 'نام دانشگاه',
            'date' => 'تاریخ شروع تحصیل',
            'to_date' => 'تاریخ پایان تحصیل',
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
