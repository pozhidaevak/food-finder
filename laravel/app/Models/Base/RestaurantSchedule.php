<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 12 Mar 2017 13:46:55 +0000.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RestaurantSchedule
 * 
 * @property \Carbon\Carbon $time_from
 * @property \Carbon\Carbon $time_to
 * @property int $restaurant_id
 * @property int $weekday_names_id
 * 
 * @property \App\Models\Restaurant $restaurant
 * @property \App\Models\WeekdayName $weekday_name
 *
 * @package App\Models\Base
 */
class RestaurantSchedule extends Eloquent
{
	protected $table = 'restaurant_schedule';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'restaurant_id' => 'int',
		'weekday_names_id' => 'int'
	];

	protected $dates = [
		'time_from',
		'time_to'
	];

	public function restaurant()
	{
		return $this->belongsTo(\App\Models\Restaurant::class);
	}

	public function weekday_name()
	{
		return $this->belongsTo(\App\Models\WeekdayName::class, 'weekday_names_id');
	}
}
