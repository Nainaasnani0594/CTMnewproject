<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = $this->route('project'); // Get the project from the route
        return Gate::allows('update', $project); // Check if the user is authorized to update the project
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
            'project_manager' => 'nullable|exists:users,id',
            'currency' => 'required|string|max:10',
            'contract_value' => 'nullable|numeric',
            'contract_signed' => 'required|boolean',
            'billing_type' => 'required|string|max:255',
            'activity_start_date' => 'nullable|date',
            'billing_start_date' => 'nullable|date',
            'clinical_duration' => 'nullable|numeric',
            'study_duration' => 'nullable|numeric',
            'patients' => 'nullable|numeric',
            'sites' => 'nullable|numeric',
            'status' => 'required|boolean',
            'phase' => 'nullable|integer',
            'therapeutic_area' => 'nullable|string|max:255',
            'sponsor_country' => 'nullable|string|max:255',
        ];
        }
}
