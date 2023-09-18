<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
	use HasFactory;
	/** 
	 * nameTable 
	 */
	protected $table = 'locations';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 
		'name', 
		'code_iso',
		'locations_parent_id',
	];
}
