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

        $locales = $this->getLocales();

        //retrieving lists of all restaurants
        $restaurants = Restaurant::all();

        $foods = Food::all()->map(function($item) use (&$currentLocale) {
            return $item->toCustomJson($currentLocale);
        });

        return view('restaurants', compact('restaurants', 'currentLocale', 'locales', 'foods'));
    }

    /**
     * @param CookieJar $cookieJar
     * @param $currentLocale
     * @param $id id of restaurant
     */
    public function show(CookieJar $cookieJar, $currentLocale, $id )
    {
        $this->setLocale($cookieJar, $currentLocale);
        $locales = $this->getLocales();
        $restaurant = Restaurant::all()->where('id', $id)->first();
        $menu = $restaurant->foods;

        foreach ($menu as $food) { //adding parents
            $path = $food->path;
            $slashCount = substr_count($path, '/');
            while ($slashCount > 1) {
                $path = substr($path,0,strrpos($path,'/',-1));
                $menu = $menu->merge(Food::all()->where('path', $path));
                $slashCount = substr_count($path, '/');
            }
        }
        $menu = $menu->map(function($item) use (&$currentLocale) {
            return $item->toCustomJson($currentLocale);
        });
        $postcode = $restaurant->postcode()->first();
        $address = $restaurant->adr_firstline .' ' . $postcode->adr_secondline . "<br>" .
            $postcode->city . "<br>" . $postcode->county . "<br>" .
            $postcode->postcode;
        return view('restaurant', compact('restaurant', 'currentLocale', 'locales', 'menu', 'address' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
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

    protected function setLocale(CookieJar $cookieJar, $currentLocale) {
        //setting locale
        \App::setLocale($currentLocale);

        //Adding cookie with current local
        $cookieJar->queue(cookie('lang', $currentLocale));//
    }

    protected function getLocales() {
        //retrieving list of locales and converting it to associative array
        $langs = Language::all();
        $locales = array();
        foreach($langs as $lang) {
            $locales[$lang->code] = $lang->native_name . ' (' . $lang->eng_name . ')';
        }
        return $locales;
    }
}
