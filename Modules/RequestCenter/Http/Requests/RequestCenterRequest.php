<?php

namespace Modules\RequestCenter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCenterRequest extends FormRequest
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
            'text_content' => 'required',
        ];
    }

    public function attributes()
    {
       return [
           'title' => 'عنوان درخواست',
           'text_content' => 'محتوای درخواست',
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
