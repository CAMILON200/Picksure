<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikeImageproduct extends Model
{
    use HasFactory;
    /** 
     * nameTable 
    */
    protected $table = 'user_like_imageproduct';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 
        'imageproduct_id',
    ];

    const UPDATED_AT = null;
}
