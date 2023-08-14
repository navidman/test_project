<?php

namespace Modules\PageBuilder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageBuilderRequest extends FormRequest
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
            'content_text' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'عنوان برگه',
            'content_text' => 'محتوای برگه',
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
