<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'phone',
        'birth_date',
        'address',
        'profile_image',
        'department',
        'hourly_rate'
    ];

    /**
     * ความสัมพันธ์กับ User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workHours()
{
    return $this->hasMany(Work::class, 'user_id', 'user_id');
}

}
