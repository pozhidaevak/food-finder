#!/bin/bash
tables=(postcode language food weekday_names restaurant restaurant_schedule restaurant_has_food restaurant_transl food_transl)

for table in ${tables[*]}
do
    echo "${table}"
done