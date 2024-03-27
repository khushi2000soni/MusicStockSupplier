<?php

namespace App\Http\Requests\PaymentReceipt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        abort_if((Gate::denies('payment_receipt_edit')), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    public function rules()
    {
        return [
            'remark' => ['nullable','string'],
            'amount' => ['required','numeric'],
            'payment_date' => ['required','date'],
            'supplier_id'=>['required','numeric','exists:suppliers,id'],
            'payment_receipt_proof' => ['nullable','file','mimes:jpg,png,pdf','max:2048']
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
