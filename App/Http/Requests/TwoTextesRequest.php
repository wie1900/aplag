<?php

namespace Aplag\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TwoTextesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'text1' => 'required|min:2',
            'text2' => 'required|min:2',
            'security' => 'present|max:0'
        ];
    }

    public function messages()
    {
        return [
            'text1' => 'Checked text must contain 2 characters or more',
            'text2' => 'Source text must contain 2 characters or more',
            'security' => 'The field below must stay empty'
        ];
    }

}
