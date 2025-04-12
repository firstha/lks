<?php

namespace App\Http\Requests\API\V1\Game;

use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UploadGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $game = Game::where('slug', $this->slug)->first();

        // return $game->created_by == Auth::user()->id;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'zipfile' => ['required', 'file', 'mimes:zip'],
            // 'slug' => ['required', 'string', 'exists:games,slug'],
        ];
    }
}
