<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 12 Mar 2017 13:46:55 +0000.
 */

namespace App\Models\Base;

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
 * @package App\Models\Base
 */
class Postcode extends Eloquent
{
	protected $table = 'postcode';
	protected $primaryKey = 'postcode';
	public $incrementing = false;
	public $timestamps = false;

	public function restaurants()
	{
		return $this->hasMany(\App\Models\Restaurant::class, 'postcode');
	}
}
