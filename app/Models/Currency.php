<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @method static create(array $currency)
 * @method static select(string $string, string $string1)
 * @method static find($currency)
 */
class Currency extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    public $translatable = ['currency_name'];


    protected $fillable = [
        'currency_code','currency_name','symbol','active'
    ];
}
