<?php

namespace Modules\ResumeManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMyResumeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'education' => 'required',
            'experience' => 'required|max:100',
            'job_status' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'education' => 'سطح تحصیلات',
            'experience' => 'سابقه کاری',
            'job_status' => 'وضعیت استخدام'
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
