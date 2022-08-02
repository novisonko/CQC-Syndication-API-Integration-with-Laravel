<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;
use App\Models\Provider;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res= json_decode(file_get_contents('https://api.cqc.org.uk/public/v1/providers'), true)['providers'] ?? [];

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProviderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProviderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(string $providerId)
    {
        $res= [];

        $saved= Provider::where('provider_id', '=', $providerId)->first();

        if(!is_null($saved)){

        } else {

            $res= json_decode(file_get_contents('https://api.cqc.org.uk/public/v1/providers/' . $providerId), true);

        }

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        //
    }
}
