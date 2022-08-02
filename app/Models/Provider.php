<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['providerId','locationIds','organisationType','ownershipType','type','name','brandId','brandName','registrationStatus','registrationDate','companiesHouseNumber','charityNumber','website','postalAddressLine1','postalAddressLine2','postalAddressTownCity','postalAddressCounty','region','postalCode','uprn','onspdLatitude','onspdLongitude','mainPhoneNumber','inspectionDirectorate','constituency','localAuthority','lastInspection','timestampUpdated']; 

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

        $saved= Provider::where('providerId', '=', $providerId)->get()->toArray()[0] ?? [];

        if(!empty($saved)){

            // if cached data is too old, empty cache
            if((time() - $saved['timestampUpdated']) > $cacheLife){

                $saved= [];
                Provider::where('providerId', '=', $providerId)->delete();

            }

            $res= $saved;

        } 
        
        if(empty($res)){

            $res= json_decode(file_get_contents('https://api.cqc.org.uk/public/v1/providers/' . $providerId), true);

            if(!empty($res)){

                $temp= [];

                // get accepted data
                foreach($this->fillable as $key){

                   $temp[$key]= $res[$key] ?? '';

                }

                $res= $temp;

                $res['timestampUpdated']= time();
                $res['charityNumber']= (int) $res['charityNumber'];
                $res['locationIds']= implode(',', $res['locationIds'] ?? []);
                $res['lastInspection']= $res['lastInspection']['date'] ?? date('Y-m-d');

                $provider= new Provider($res);

                $provider->save();

                $res= Provider::where('providerId', '=', $providerId)->get()->toArray()[0] ?? [];

            }
        }

        return $res;
    }
}
