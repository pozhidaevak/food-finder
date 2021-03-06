<?php

namespace App\Models;

use Carbon\Carbon;

class Restaurant extends \App\Models\Base\Restaurant
{
    protected $fillable = [
        'is_active',
        'lat',
        'lng',
        'postcode',
        'adr_firstline',
        'phone',
        'website',
        'name'
    ];
    const timeDisplFormat = 'H:i';

    /**
     * @return string Human readable string that determinate if restaurant is open now and when it will be open
     *
     */
    public function openString()
    {


        $dayOfWeek = Carbon::now()->dayOfWeek;

        $tdSchedule = $this->restaurant_schedules()->where('weekday_names_id', $dayOfWeek)->first();

        if (Carbon::now()->between($tdSchedule->time_from, $tdSchedule->time_to)) { // if works now
            return __("Open till: ") . $tdSchedule->time_to->format(Restaurant::timeDisplFormat);
        } else if (Carbon::now()->lt($tdSchedule->time_from)) { //if still hasn't opened today
            return __("Will open at: ") . $tdSchedule->time_from->format(Restaurant::timeDisplFormat);
        } else { //already closed today
            $tmDayOfWeek = Carbon::now()->addDay()->dayOfWeek;
            return __("Will open tomorrow at: ") .
                $this->restaurant_schedules()->where('weekday_names_id', $tmDayOfWeek)->first()->time_from->format(Restaurant::timeDisplFormat);
        }
    }


}
