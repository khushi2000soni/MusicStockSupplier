<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PaymentReceipt extends Model
{
    use HasFactory,Notifiable,SoftDeletes;
    public $table = 'payment_receipts';

    protected $fillable = [
        'supplier_id',
        'amount',
        'remark',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function(PaymentReceipt $model) {
            $model->created_by = auth()->user()->id;
        });

        static::deleting(function(PaymentReceipt $model) {
            $model->deleted_by = auth()->user()->id;
            $model->save();
        });

        static::updating(function(PaymentReceipt $model) {
            $model->updated_by = auth()->user()->id;
        });
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }


    public function uploads()
    {
        return $this->morphMany(Uploads::class, 'uploadsable');
    }

    public function paymentDocument()
    {
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type', 'payment_receipt_proof');
    }

    public function getPaymentDocumentUrlAttribute()
    {
        if ($this->paymentDocument) {
            return $this->paymentDocument->file_url;
        }
        return "";
    }
}
