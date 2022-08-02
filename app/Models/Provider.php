<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    /**
     * Get all records
     * 
     * @return array
     */
    public function selectAll()
    {
        return json_decode(file_get_contents('https://api.cqc.org.uk/public/v1/providers'), true)['providers'] ?? [];
    }

    /**
     * Get a record
     * 
     * @param string $providerId
     * 
     * @return array
     */
    public function selectByProviderId(string $providerId)
    {
        $res= [];
        // one week cache life
        $cacheLife= 7 * 24 * 3600;

        $saved= Provider::where('provider_id', '=', $providerId)->first();

        if(!is_null($saved)){

            // if cached data is too old, empty cache
            if((time() - $saved['timestamp_updated']) > $cacheLife){

                $saved= null;
                Provider::where('provider_id', '=', $providerId)->delete();

            }

        } else {

            $res= json_decode(file_get_contents('https://api.cqc.org.uk/public/v1/providers/' . $providerId), true);

            if(!empty($res)){

                $res['timestamp_updated']= time();

                $provider= new Provider($res);
                $provider->save();

                $res= Provider::where('provider_id', '=', $providerId)->first();

            }
        }

        return $res;
    }
}
