<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 05 Mar 2017 22:34:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RestaurantHasFood
 * 
 * @property int $restaurant_id
 * @property string $food_path
 * 
 * @property \App\Models\Food $food
 * @property \App\Models\Restaurant $restaurant
 *
 * @package App\Models
 */
class RestaurantHasFood extends Eloquent
{
	protected $table = 'restaurant_has_food';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'restaurant_id' => 'int'
	];

	public function food()
	{
		return $this->belongsTo(\App\Models\Food::class, 'food_path');
	}

	public function restaurant()
	{
		return $this->belongsTo(\App\Models\Restaurant::class);
	}
}
