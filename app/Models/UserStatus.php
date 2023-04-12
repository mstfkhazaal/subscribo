<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @method static create(array $array)
 */
class UserStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $translatable = ['name'];


    protected $fillable = [
       'code', 'name','variant','active'
    ];

    public function getNameAttribute($value)
    {
        $names = Collection::make(json_decode($value, true));
        $localized = $names->get(app()->getLocale());
        $english = $names->get('en');
        $default = $names->first();

        return $localized ?? $english ?? $default;
    }

}
