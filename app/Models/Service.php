<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @property false|mixed $active
 */
class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['name'];


    protected $fillable = [
        'name','amount','team_id','active','currency'
    ];

    public function teams(): BelongsTo
    {
        return $this->belongsTo(Team::class,'team_id');
    }

    public function currency(): BelongsTo {
        return $this->belongsTo(Currency::class,'id');
    }
}
