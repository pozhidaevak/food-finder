<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 05 Mar 2017 22:34:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Restaurant
 * 
 * @property int $id
 * @property bool $is_active
 * @property float $lat
 * @property float $lng
 * @property string $postcode
 * @property string $smallimage
 * @property string $bigimage
 * @property string $adr_firstline
 * @property string $phone
 * @property string $website
 * 
 * @property \Illuminate\Database\Eloquent\Collection $foods
 * @property \Illuminate\Database\Eloquent\Collection $restaurant_schedules
 * @property \Illuminate\Database\Eloquent\Collection $restaurant_transls
 *
 * @package App\Models
 */
class Restaurant extends Eloquent
{
	protected $table = 'restaurant';
	public $timestamps = false;

	protected $casts = [
		'is_active' => 'bool',
		'lat' => 'float',
		'lng' => 'float'
	];

	protected $fillable = [
		'is_active',
		'lat',
		'lng',
		'postcode',
		'smallimage',
		'bigimage',
		'adr_firstline',
		'phone',
		'website'
	];

	public function postcode()
	{
		return $this->belongsTo(\App\Models\Postcode::class, 'postcode');
	}

	public function foods()
	{
		return $this->belongsToMany(\App\Models\Food::class, 'restaurant_has_food', 'restaurant_id', 'food_path');
	}

	public function restaurant_schedules()
	{
		return $this->hasMany(\App\Models\RestaurantSchedule::class);
	}

	public function restaurant_transls()
	{
		return $this->hasMany(\App\Models\RestaurantTransl::class);
	}
}
