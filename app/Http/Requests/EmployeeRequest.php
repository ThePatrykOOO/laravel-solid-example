<?php

namespace App\Http\Requests;

use App\Enums\EmployeePositions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255', 'min:3'],
            'last_name' => ['required', 'string', 'max:255', 'min:3'],
            'department_id' => ['required', 'exists:departments,id'],
            'role' => ['required', new Enum(EmployeePositions::class)],
            'usd_salary' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
