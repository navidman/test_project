<?php

namespace Modules\ResumeMetaData\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorksSampleHistoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'attachments' => 'required_if:type,==,image',
            'title' => 'required_if:type,==,link',
            'url' => 'required_if:type,==,link',
        ];
    }

    public function attributes()
    {
        return [
            'type' => 'نوع نمونه کار',
            'attachments' => 'عکس',
            'title' => 'عنوان',
            'url' => 'لینک',
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
