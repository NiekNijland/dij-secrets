<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            'colleague_email' => [],
            'message' => ['required', 'string', 'max:512'],
        ];

        if (!empty($this->get('colleague_email'))) {
            $rules['colleague_email'][] = 'email';
        }

        return $rules;
    }
}
