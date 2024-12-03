<?php

namespace App\Http\Requests\Employee;

use App\Rules\PersonDocumentoNumber;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeStore extends FormRequest
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
            //
            'name' => 'required|string',
            'email' => 'required|email',
            'document_number' => ['required', 'string', new PersonDocumentoNumber],
            'state' => 'required|string',
            'city' => 'required|string',
        ];
    }
}
