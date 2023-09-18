<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageproductsCategory extends Model
{
    use HasFactory;
    /** 
     * nameTable 
    */
    protected $table = 'imageproducts_category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'imageproduct_id', 
        'category_id',
    ];

    const UPDATED_AT = null;
}
