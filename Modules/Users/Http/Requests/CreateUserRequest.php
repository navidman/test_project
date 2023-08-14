<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'password' => 'required|min:8',
            'role' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'full_name' => 'نام و نام خانوادگی',
            'email' => 'آدرس ایمیل',
            'password' => 'رمز عبور',
            'role' => 'سطح دسترسی',
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
