<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'columns';

    protected $fillable = [
        'project_id',
        'name',
        'order',
        'time',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function getTimeAttribute($value)
    {
        return $value;
    }

    public function cards ()
    {
        return $this->hasMany(Card::class);
    }

    public function project ()
    {
        return $this->belongsTo(Project::class);
    }
}
