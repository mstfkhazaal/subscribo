<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $translatable = ['name','address'];


    protected $fillable = [
        'name', 'phone', 'address','team_id','active'
    ];

    /**
     * Get all of the teams the user belongs to.
     *
     * @return BelongsTo
     */
    public function teams(): BelongsTo
    {
        return $this->belongsTo(Team::class,'id');
    }
}
