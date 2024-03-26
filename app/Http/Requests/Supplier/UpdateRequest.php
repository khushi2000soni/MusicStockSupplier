<?php

namespace App\Http\Requests\Supplier;

use App\Rules\TitleValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name is required.',
            'name.string' => 'The name should be a valid string.',
            'name.max' => 'The name should not exceed 150 characters.',
        ];
    }
}
