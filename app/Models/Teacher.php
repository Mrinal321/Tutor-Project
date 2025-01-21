<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Teacher extends Model
{
    use HasFactory;
    use Rateable;
    protected $fillable = ['name', 'university', 'department', 'vote', 'image', 'total_star', 'count'];

    public function voters()
    {
        return $this->belongsToMany(User::class, 'teacher_user')->withPivot('star')->withTimestamps();
    }
}
