<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 05 Mar 2017 22:34:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class FoodTransl
 * 
 * @property string $food_path
 * @property string $language_code
 * @property string $name
 * 
 * @property \App\Models\Food $food
 * @property \App\Models\Language $language
 *
 * @package App\Models
 */
class FoodTransl extends Eloquent
{
	protected $table = 'food_transl';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function food()
	{
		return $this->belongsTo(\App\Models\Food::class, 'food_path');
	}

	public function language()
	{
		return $this->belongsTo(\App\Models\Language::class, 'language_code');
	}
}
