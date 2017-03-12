<?php

namespace App\Models;

class Postcode extends \App\Models\Base\Postcode
{
	protected $fillable = [
		'city',
		'county',
		'adr_secondline'
	];
}
