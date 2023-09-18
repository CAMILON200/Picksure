<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextsImageproducts extends Model
{
    use HasFactory;
    /** 
     * nameTable 
    */
    protected $table = 'texts_imageproducts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imageproduct_id', 
        'language',
        'title', 
        'description',
    ];

    const UPDATED_AT = null;
}
