<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	use HasFactory;
	/** 	
	 * nameTable 
	 */
	protected $table = 'languages';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 
		'name', 
		'prefijo',
	];
	
}
