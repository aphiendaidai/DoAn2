<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    //
    protected $table = 'job';
    public function jobType() {
        return $this->belongsTo(JobType::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function user1(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applications(){
        return $this->hasMany(JobApplication::class);
    }


}
