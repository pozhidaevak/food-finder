<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 05 Mar 2017 22:34:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Food
 * 
 * @property string $path
 * @property bool $isfood
 * 
 * @property \Illuminate\Database\Eloquent\Collection $food_transls
 * @property \Illuminate\Database\Eloquent\Collection $restaurants
 *
 * @package App\Models
 */
class Food extends Eloquent
{
	protected $table = 'food';
	protected $primaryKey = 'path';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'isfood' => 'bool'
	];

	protected $fillable = [
		'isfood'
	];

	public function food_transls()
	{
		return $this->hasMany(\App\Models\FoodTransl::class, 'food_path');
	}

	public function restaurants()
	{
		return $this->belongsToMany(\App\Models\Restaurant::class, 'restaurant_has_food', 'food_path');
	}
}
