<?php

namespace App\Rules\API\V1\Auth\SignIn;

use App\Models\Administrator;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UsernameExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $users = User::where('username', $value)->get();
        $administrators = Administrator::where('username', $value)->get();

        if ($users->isEmpty() && $administrators->isEmpty()) {
            $fail('The :attribute does not exist.');
        }
    }
}
