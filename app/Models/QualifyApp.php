<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualifyApp extends Model
{
	use HasFactory;
	/** 
	 * nameTable 
	 */
	protected $table = 'qualify_app';
	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 
		'user_id',
		'action', 
		'answer_date', 
		'date_ask_again', 
	];

}
