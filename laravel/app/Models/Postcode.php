<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 05 Mar 2017 22:34:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Postcode
 * 
 * @property string $postcode
 * @property string $city
 * @property string $county
 * @property string $adr_secondline
 * 
 * @property \Illuminate\Database\Eloquent\Collection $restaurants
 *
 * @package App\Models
 */
class Postcode extends Eloquent
{
	protected $table = 'postcode';
	protected $primaryKey = 'postcode';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'city',
		'county',
		'adr_secondline'
	];

	public function restaurants()
	{
		return $this->hasMany(\App\Models\Restaurant::class, 'postcode');
	}
}
