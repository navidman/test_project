<?php

namespace Modules\Newsletter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact' =>  'required|unique:newsletter,contact',
        ];
    }

    public function attributes()
    {
        return [
            'contact' => 'ایمیل یا موبایل'
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
