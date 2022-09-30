<?php

namespace App\Models;

use App\Models\classrooms;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class sections extends Model
{
    use HasTranslations;

    protected $translatable = ['section_name'];

    protected $fillable = ['section_name', 'status', 'grade_id', 'class_id'];

    protected $table = 'sections';
    public $timestamps = true;



    // علاقة بين الاقسام و الصفوف لجلب اسم الصف في جدول الاقسام

    public function My_classes()
    {
        return $this->belongsTo(classrooms::class, 'class_id');
    }
}
