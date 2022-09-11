<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'team_id',
        'name',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function team ()
    {
        return $this->belongsTo(Team::class);
    }

    public function columns()
    {
        return $this->hasMany(Column::class);
    }
}
