<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 12 Mar 2017 13:46:55 +0000.
 */

namespace App\Models\Base;

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
 * @package App\Models\Base
 */
class FoodTransl extends Eloquent
{
	protected $table = 'food_transl';
	public $incrementing = false;
	public $timestamps = false;

	public function food()
	{
		return $this->belongsTo(\App\Models\Food::class, 'food_path');
	}

	public function language()
	{
		return $this->belongsTo(\App\Models\Language::class, 'language_code');
	}
}
