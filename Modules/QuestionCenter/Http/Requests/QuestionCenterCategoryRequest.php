<?php

namespace Modules\QuestionCenter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionCenterCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان'
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
