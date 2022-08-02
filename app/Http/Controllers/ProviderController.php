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
    public function index(\App\Models\Provider $provider)
    {
        $res= $provider->selectAll();

        return response()->json(['success' => true, 'data' => $res]);
    }

    /**
     * Display the specified resource.
     *
     * @param string  $providerId
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\Provider $provider, string $providerId)
    {
        $res= $provider->selectByProviderId($providerId);

        return response()->json(['data' => $res]);
    }
}
