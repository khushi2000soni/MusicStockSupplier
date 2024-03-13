<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PaymentReceipt extends Model
{
    use HasFactory,Notifiable,SoftDeletes;
    public $table = 'entries';

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
}
