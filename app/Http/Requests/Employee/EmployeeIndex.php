<?php

namespace App\Http\Requests\Employee;

use App\Rules\PersonDocumentoNumber;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeIndex extends FormRequest
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
            'page' => 'sometimes|int|min:1',
        ];
    }
}
