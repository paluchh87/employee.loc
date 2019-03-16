<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Employee
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employee query()
 * @mixin \Eloquent
 */
class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'position',
        'parent_id',
    ];

//    public function superviser()
//    {
//        return $this->belongsTo(self::class, 'parent_id', 'id');
//    }
//
//    public function subordinates()
//    {
//        return $this->hasMany(self::class, 'parent_id', 'id');
//    }
}
