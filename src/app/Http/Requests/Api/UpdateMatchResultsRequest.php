<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchResultsRequest extends FormRequest
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
            'match_id' => 'required',
            'home_team_id' => 'required',
            'home_team_goals' => 'required|min:0',
            'guest_team_id' => 'required',
            'guest_team_goals' => 'required|min:0',
        ];
    }
}
