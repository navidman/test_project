<?php

namespace Modules\RequestCenter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRepliesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content_text' => 'required|min:5'
        ];
    }

    public function attributes()
    {
        return [
            'content_text' => 'متن پیام'
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
