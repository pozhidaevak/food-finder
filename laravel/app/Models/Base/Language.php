<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 12 Mar 2017 13:46:55 +0000.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Language
 * 
 * @property string $code
 * @property string $eng_name
 * @property string $native_name
 * 
 * @property \Illuminate\Database\Eloquent\Collection $food_transls
 * @property \Illuminate\Database\Eloquent\Collection $restaurant_transls
 * @property \Illuminate\Database\Eloquent\Collection $weekday_names
 *
 * @package App\Models\Base
 */
class Language extends Eloquent
{
	protected $table = 'language';
	protected $primaryKey = 'code';
	public $incrementing = false;
	public $timestamps = false;

	public function food_transls()
	{
		return $this->hasMany(\App\Models\FoodTransl::class, 'language_code');
	}

	public function restaurant_transls()
	{
		return $this->hasMany(\App\Models\RestaurantTransl::class, 'language_code');
	}

	public function weekday_names()
	{
		return $this->hasMany(\App\Models\WeekdayName::class, 'language_code');
	}
}
