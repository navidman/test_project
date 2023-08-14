<?php

namespace Modules\ResumeMetaData\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseHistoryRequest extends FormRequest
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
            'university' => 'required',
            'date' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'field_of_study' => 'عنوان دوره',
            'university' => 'نام موسسه',
            'date' => 'تاریخ دوره',
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
