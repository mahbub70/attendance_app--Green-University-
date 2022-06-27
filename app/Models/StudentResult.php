<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function department(){
        return $this->belongsTo(Departments::class);
    }

    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class,'student_id');
    }
}
