<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Supplier extends Model
{
    use HasFactory,Notifiable,SoftDeletes;
    public $table = 'suppliers';

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'updated_at',
        'deleted_at',
        'is_active',
    ];

    protected $appends = [
        'closing_balance',
        'total_debit_amount',
        'total_credit_amount'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function(Supplier $model) {
            $model->created_by = auth()->user()->id;
        });

        static::deleting(function(Supplier $model) {
            $model->deleted_by = auth()->user()->id;
            $model->save();
        });

        static::updating(function(Supplier $model) {
            $model->updated_by = auth()->user()->id;
        });
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    public function payment_receipts()
    {
        return $this->hasMany(PaymentReceipt::class);
    }

    public function getTotalDebitAmountAttribute()
    {
        return $this->entries()->sum('amount');
    }

    public function getTotalCreditAmountAttribute()
    {
        return $this->payment_receipts()->sum('amount');
    }

    public function getClosingBalanceAttribute()
    {
        $closingBalance = $this->total_debit_amount - $this->total_credit_amount;
        $closingBalance = number_format($closingBalance, 2);
        return $closingBalance;
    }



}
