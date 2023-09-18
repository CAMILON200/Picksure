<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PautasUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'valor',
        'description',
        'destination_url',
        'img_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}
