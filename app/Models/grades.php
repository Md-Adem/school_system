<?php

namespace App\Models;

use App\Models\sections;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class grades extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $translatable = ['name'];

    protected $fillable = ['name', 'notes'];
    protected $table = 'grades';
    public $timestamps = true;



    // علاقة المراحل الدراسية لجلب الاقسام المتعلقة بكل مرحلة
    public function Sections()
    {
        return $this->hasMany(sections::class, 'grade_id');
    }
}
