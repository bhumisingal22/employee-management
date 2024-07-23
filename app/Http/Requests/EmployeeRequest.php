<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // validation rules for employee creation
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:255',
            'profile_pic' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ];

         // If updating an existing employee, exclude the current employee's email from the unique check
        if ($this->route('employee')) {
            $rules['email'] .= ',' . $this->route('employee')->id;
        }

        return $rules;
    }
}
