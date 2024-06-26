<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Models\Address\City;
use App\Models\Address\Region;
use App\Models\Address\Street;
use App\Models\Order\Order;
use Exception;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       try{ $city = City::create([
            'name' => $request->city_name,
        ]);
        $region= Region::create([
            'name'=>$request->region_name,
            'city_id'=>$city->id,
        ]);
        $street= Street::create([
            'name'=>$request->street_name,
            'region_id'=>$region->id,
            'user_id'=>1,
        ]);
    return " تم بنجاح";
    }
    catch( Exception $ex){
        return " لم يتم بنجاح";
    }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
