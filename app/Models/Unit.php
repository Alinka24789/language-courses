<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Unit
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Unit onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Unit withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Unit withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereUpdatedAt($value)
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Unit whereDeletedAt($value)
 * @property-read \App\Models\Course $course
 */
class Unit extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'course_id'
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
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

}
