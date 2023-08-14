<?php

namespace Modules\SupportSystem\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketReplyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'replay_text' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'replay_text' => 'پاسخ'
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
