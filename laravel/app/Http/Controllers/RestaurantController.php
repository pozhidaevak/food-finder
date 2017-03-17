<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Restaurant;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Cookie\CookieJar;


class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param CookieJar $cookieJar
     * @param $currentLocale string with name of current locale
     * @return \Illuminate\Http\Response
     * @internal param $
     */
    public function index(CookieJar $cookieJar, $currentLocale)
    {
        //setting locale
        \App::setLocale($currentLocale);

        //Adding cookie with current local
        $cookieJar->queue(cookie('lang', $currentLocale));


        //retrieving list of locales and converting it to associative array
        $langs = Language::all();
        $locales = array();
        foreach($langs as $lang) {
            $locales[$lang->code] = $lang->native_name . ' (' . $lang->eng_name . ')';
        }

        //retrieving lists of all restaurants
        $restaurants = Restaurant::all();

        $foods = Food::all()->map(function($item) use (&$currentLocale) {
            return $item->toCustomJson($currentLocale);
        });

        return view('restaurants', compact('restaurants', 'currentLocale', 'locales', 'foods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit(Restaurant $restaurant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}
