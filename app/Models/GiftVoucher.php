<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftVoucher extends Model
{
	use HasFactory;
	/** 
	 * nameTable 
	 */
	protected $table = 'gift_voucher';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'id', 
		'code',
		'type_gift', 
		'amount',
		'state',
	];
}
