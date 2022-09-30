<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class religion extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $translatable = ['name'];

    protected $fillable = ['name'];
}
