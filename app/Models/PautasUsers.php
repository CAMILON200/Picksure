<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PautasUsers extends Model
{
    use HasFactory;

    public function categories_pauta()
	{
        return $this->hasMany('App\Models\CategoriesPauta', 'App\Models\LocationsPauta','category_id', 'location_prefix', 'pauta_id', 'pauta_id')->withPivot(
            'id',
            'user_id',
            'valor',
            'description',
            'destination_url',
            'category_id',
            'location_prefix',
            'img_url'
        );
	} 
   
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
