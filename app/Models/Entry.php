<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Entry extends Model
{
    use HasFactory,Notifiable,SoftDeletes;
    public $table = 'entries';

    protected $fillable = [
        'supplier_id',
        'amount',
        'remark',
        'entry_date',
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
        static::creating(function(Entry $model) {
            $model->created_by = auth()->user()->id;
        });

        static::deleting(function(Entry $model) {
            $model->deleted_by = auth()->user()->id;
            $model->save();
        });

        static::updating(function(Entry $model) {
            $model->updated_by = auth()->user()->id;
        });
    }

    // Define a mutator for the entry_date attribute
    public function setEntryDateAttribute($value)
    {
        // Parse the incoming date string and convert it to the desired format
        $this->attributes['entry_date'] = Carbon::createFromFormat('d-m-Y H:i', $value)->format('Y-m-d H:i:s');
    }

    // Define an accessor for the entry_date attribute
    public function getEntryDateAttribute($value)
    {
        // Parse the database datetime value as Carbon instance and format it
        return Carbon::parse($value)->format('d-m-Y h:i A');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }


    public function uploads()
    {
        return $this->morphMany(Uploads::class, 'uploadsable');
    }

    public function proofDocument()
    {
        return $this->morphOne(Uploads::class, 'uploadsable')->where('type', 'entryproof');
    }

    public function getProofDocumentUrlAttribute()
    {
        if ($this->proofDocument) {
            return $this->proofDocument->file_url;
        }
        return "";
    }


}
