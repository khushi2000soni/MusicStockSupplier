<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        abort_if((Gate::denies('entry_edit')), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }


    public function rules()
    {
        return [
            'remark' => ['required','string'],
            'amount' => ['required','numeric'],
            'supplier_id'=>['required','numeric','exists:suppliers,id'],
        ];
    }

    public function messages()
    {
        return [
            'remark.required' => 'The Remark is required.',
            'remark.string' => 'The Remark should be a valid string.',
            'amount.required' => 'The Amount is required.',
            'supplier_id.required'=> 'The Supplier is required.',
        ];
    }
}