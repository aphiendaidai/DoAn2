<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveJob extends Model
{
    use HasFactory;
    //
    protected $table = "saved_jobs";

    public function job(){
        return $this->belongsTo(Job::class);
    }
    
    
}
