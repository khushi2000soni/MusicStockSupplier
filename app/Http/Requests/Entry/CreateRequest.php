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
            'remark' => ['nullable','string'],
            'amount' => ['required','numeric'],
            'entry_date' => ['required','date'],
            'supplier_id'=>['required','numeric','exists:suppliers,id'],
            'proof_document' => ['nullable','file','mimes:jpg,png,pdf,csv,xls,xlss,doc,docx','max:2048']
        ];
    }

    public function messages()
    {
        return [
            'remark.required' => 'The Remark is required.',
            'remark.string' => 'The Remark should be a valid string.',
            'amount.required' => 'The Amount is required.',
            'supplier_id.required'=> 'The Supplier is required.',
            'entry_date.required'=> 'The Date is required.',
        ];
    }
}
