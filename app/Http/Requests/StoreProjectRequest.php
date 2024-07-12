<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sponsor_name' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'contract_holder_country' => 'required|string|max:255',
            'project_manager' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'contract_value' => 'required|integer',
            'contract_signed' => 'required|boolean',
            'billing_type' => 'required|string|max:255',
            'activity_start_date' => 'required|date',
            'billing_start_date' => 'required|date',
            'clinical_duration' => 'required|numeric|between:0,99999.99',
            'study_duration' => 'required|numeric|between:0,99999.99',
            'patients' => 'required|integer',
            'sites' => 'required|integer',
            'status' => 'required|boolean',
            'phase' => 'required|integer|between:0,32767',
            'therapeutic_area' => 'required|string|max:255',
            'sponsor_country' => 'required|string|max:255',
        ];
    }
}
