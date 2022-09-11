<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'column_id',
        'name',
        'description',
        'estimated_date',
        'order',
        'tag',
    ];

    protected $appends = [
        'status'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'estimated_date' => 'datetime'
    ];
    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function getStatusAttribute($value)
    {
        $now = now();
        if( $this->estimated_date > $now ){
            if( $this->estimated_date->subMinute(30) < $now ){
                return 'ATENÇÃO';
            }
            return 'EM DIA';
        }else  {
            return 'EM ATRASO';
        }
    }
}







