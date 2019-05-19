<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Course
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Course withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $language_id
 * @property string $name
 * @property string|null $description
 * @property int $year
 * @property int $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course whereYear($value)
 * @property-read \App\Models\Language $language
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Unit[] $units
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course ofLanguage($languageId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course ofLevel($level)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Course ofText($text)
 */
class Course extends Model
{
    use SoftDeletes;

    /*
     * Name of the fields for sorting collection
     */
    const NAME_COLUMN = 'name';
    const LANGUAGE_COLUMN = 'language';
    const UNITS_COLUMN = 'units';
    const LEVEL_COLUMN = 'level';

    const AVAILABLE_SORT_BY = [
        self::LANGUAGE_COLUMN,
        self::NAME_COLUMN,
        self::UNITS_COLUMN,
        self::LEVEL_COLUMN
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'language_id', 'name', 'description', 'year', 'level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'deleted_at', 'updated_at'
    ];

    /**
     * @return BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'course_id', 'id');
    }

    /**
     * @param Course $query
     * @param int $languageId
     * @return mixed
     */
    public function scopeOfLanguage($query, $languageId)
    {
        return $query->whereLanguageId($languageId);
    }

    /**
     * @param Course $query
     * @param int $level
     * @return mixed
     */
    public function scopeOfLevel($query, $level)
    {
        return $query->whereLevel($level);
    }

    /**
     * @param Course $query
     * @param string $text
     * @return mixed
     */
    public function scopeOfText($query, $text)
    {
        return $query->where(function ($query) use ($text) {
            /** @var Builder $query */
            $query->where('name', 'like', '%' . $text . '%')
                ->orWhere('description', 'like', '%' . $text . '%');
        });
    }
}
