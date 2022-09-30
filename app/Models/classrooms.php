<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\grades;

class classrooms extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = ['class_name'];


    protected $table = 'classrooms';
    public $timestamps = true;
    protected $fillable = ['class_name', 'grade_id'];


    // علاقة بين الصفوف المراحل الدراسية لجلب اسم المرحلة في جدول الصفوف

    public function grades()
    {
        return $this->belongsTo(grades::class, 'grade_id');
    }
}
