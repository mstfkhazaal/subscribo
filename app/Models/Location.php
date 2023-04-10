<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $translatable = ['name'];


    protected $fillable = [
        'name','team_id','active'
    ];

    public function teams(): BelongsTo
    {
        return $this->belongsTo(Team::class,'id');
    }
}
