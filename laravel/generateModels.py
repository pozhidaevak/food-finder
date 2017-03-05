#!/usr/bin/python
import os
tables = ["postcode", "language", "food", "weekday_names", "restaurant", "restaurant_schedule", "restaurant_has_food",
          "restaurant_transl", "food_transl"]

#create php names: foo_bar => FooBar
tablesphp = []
for table in tables:
    tablesphp.append((table,"".join(map(lambda x: x.capitalize(), table.split('_')))))

for table in tablesphp:
    filename = "app/" + table[0] + ".php"
    if os.path.exists(filename):
        os.remove(filename)

for table in tablesphp:
    os.system("php artisan krlove:generate:model " + table[1] +  " --table-name=" + table[0] + " --no-timestamps")

#php artisan make:controller RestaurantController -m Restaurant
