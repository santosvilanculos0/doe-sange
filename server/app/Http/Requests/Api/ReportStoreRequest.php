<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ReportStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'victim_name' => ['nullable', 'string', 'max:255'],
            'abuser_name' => ['nullable', 'string', 'max:255'],
            'relationship_to_victim' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'description' => ['required', 'string'],
            'attachments.*'
            => [
                'nullable',
                File::types(['mp3', 'wav', 'jpeg', 'jpg', 'png', 'pdf', 'doc', 'docx'])
                    ->min(4)
                    ->max(12 * 1024)
            ]
        ];
    }
}
