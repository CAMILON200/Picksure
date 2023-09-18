<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextsCategory extends Model
{
  use HasFactory;
  /** 
   * nameTable 
  */
  protected $table = 'texts_categories';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'category_id', 
      'language',
      'name', 
  ];

  const UPDATED_AT = null;
}
