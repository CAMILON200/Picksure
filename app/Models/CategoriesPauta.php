<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesPauta extends Model
{
    use HasFactory;

    protected $fillable = [
        'pauta_id', 
        'category_id',
    ];
}
