<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        abort_if((Gate::denies('entry_create')), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }


    public function rules()
    {
        return [
            'remark' => ['required','string'],
            'amount' => ['required','numeric'],
            'supplier_id'=>['required','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'remark.required' => 'The Name is required.',
            'remark.string' => 'The name should be a valid string.',
            'amount.required' => 'The Opening Balance is required.',
            'supplier_id.required'=> 'The Supplier is required.',
        ];
    }
}
