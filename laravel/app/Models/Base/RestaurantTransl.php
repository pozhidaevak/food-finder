<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 12 Mar 2017 13:46:55 +0000.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RestaurantTransl
 * 
 * @property int $restaurant_id
 * @property string $language_code
 * @property string $description
 * @property string $schedule_change
 * 
 * @property \App\Models\Language $language
 * @property \App\Models\Restaurant $restaurant
 *
 * @package App\Models\Base
 */
class RestaurantTransl extends Eloquent
{
	protected $table = 'restaurant_transl';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'restaurant_id' => 'int'
	];

	public function language()
	{
		return $this->belongsTo(\App\Models\Language::class, 'language_code');
	}

	public function restaurant()
	{
		return $this->belongsTo(\App\Models\Restaurant::class);
	}
}
