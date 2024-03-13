<?php

namespace App\Http\Requests\Supplier;

use App\Rules\TitleValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        abort_if((Gate::denies('supplier_create')), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }


    public function rules()
    {
        return [
            'name' => ['required','string','max:150',new TitleValidationRule],
            'email' => ['required','email','unique:suppliers,email'],
            'phone' => ['required','digits:10','numeric','unique:suppliers,phone'],
            'opening_balance' => ['required','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name is required.',
            'name.string' => 'The name should be a valid string.',
            'name.max' => 'The name should not exceed 150 characters.',
            'guardian_name.required' => 'The Husband/Father Name is required.',
            'guardian_name.string' => 'The Husband/Father Name should be a valid string.',
            'guardian_name.max' => 'The Husband/Father Name should not exceed 150 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already in use.',
            'phone.required' => 'The Phone number is required.',
            'phone.digits' => 'The Phone number must be 10 digits.',
            'phone.numeric' => 'The Phone number must be a number.',
            'phone.unique' => 'The Phone number has already been taken.',
            'opening_balance.required' => 'The Opening Balance is required.',
        ];
    }
}
