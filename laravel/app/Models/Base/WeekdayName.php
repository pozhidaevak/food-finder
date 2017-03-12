<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 12 Mar 2017 13:46:55 +0000.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class WeekdayName
 * 
 * @property int $id
 * @property string $name
 * @property string $language_code
 * 
 * @property \App\Models\Language $language
 * @property \Illuminate\Database\Eloquent\Collection $restaurant_schedules
 *
 * @package App\Models\Base
 */
class WeekdayName extends Eloquent
{
	public $timestamps = false;

	public function language()
	{
		return $this->belongsTo(\App\Models\Language::class, 'language_code');
	}

	public function restaurant_schedules()
	{
		return $this->hasMany(\App\Models\RestaurantSchedule::class, 'weekday_names_id');
	}
}
