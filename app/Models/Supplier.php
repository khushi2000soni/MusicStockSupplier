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
        'email',
        'phone',
        'opening_balance',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'updated_at',
        'deleted_at',
        'is_active',
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

}
