<?php

namespace App\Http\Requests\PaymentReceipt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        abort_if((Gate::denies('payment_receipt_create')), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }


    public function rules()
    {
        return [
            'remark' => ['required','string'],
            'amount' => ['required','numeric'],
            'supplier_id'=>['required','numeric','exists:suppliers,id'],
            'payment_receipt_proof' => ['required','file','mimes:jpg,png,pdf,csv,xls,xlss,doc,docx','max:2048']
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
