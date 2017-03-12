<?php

namespace App\Models;

class RestaurantSchedule extends \App\Models\Base\RestaurantSchedule
{
	protected $fillable = [
		'time_from',
		'time_to'
	];
    protected $dateFormat = 'H:i:s';
}
