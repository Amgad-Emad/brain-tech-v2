<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'company' => ['nullable', 'string', 'max:150'],
            'service' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'min:10', 'max:4000'],
            // Honeypot + time-trap are validated silently in the controller
            // (see ContactController::detectBot) so bots get no error signal.
            'website' => ['nullable', 'string', 'max:255'],
            'ts' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('site.contact.name'),
            'email' => __('site.contact.email'),
            'company' => __('site.contact.company'),
            'service' => __('site.contact.service'),
            'message' => __('site.contact.message'),
        ];
    }
}
