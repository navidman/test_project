<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'desc' => 'required',
            'content_text' => 'required|min:10',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان مطلب',
            'desc' => 'چکیده مطلب',
            'content_text' => 'محتوای مطلب',
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
