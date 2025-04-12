<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Rules\API\V1\Auth\SignIn\UsernameExistsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SingInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' =>  [
                'required',
                'min:4',
                'max:60',
                new UsernameExistsRule(),
            ],
            'password' => [
                'required',
                'min:5',
                'max:20',
            ],
        ];
    }
}
