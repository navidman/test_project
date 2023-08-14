<?php

namespace Modules\QuestionCenter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionCenterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:10',
            'content_text' => 'required',
            'status' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'سوال',
            'content_text' => 'پاسخ',
            'status' => 'وضعیت',
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
