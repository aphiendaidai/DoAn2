<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Jobapplication extends Model
{
    //
    protected $table = 'job_applications';

    use HasFactory;
    public function job() {
        return $this->belongsTo(Job::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function employer(){
        return $this->belongsTo(User::class,foreignKey: 'employer_id');
    }
    

}
