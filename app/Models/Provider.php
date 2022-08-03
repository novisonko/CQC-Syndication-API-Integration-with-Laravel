<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = ['providerId','locationIds','organisationType','ownershipType','type','name','brandId','brandName','registrationStatus','registrationDate','companiesHouseNumber','charityNumber','website','postalAddressLine1','postalAddressLine2','postalAddressTownCity','postalAddressCounty','region','postalCode','uprn','onspdLatitude','onspdLongitude','mainPhoneNumber','inspectionDirectorate','constituency','localAuthority','lastInspection','timestampUpdated']; 

    /**
     * Get list of providers
     * 
     * @return array
     */
    /**
     * @OA\Get(
     *      path="/providers",
     *      operationId="selectAll",
     *      tags={"List Providers"},
     *      summary="Get list of providers",
     *      description="Returns list of providers",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *     )
     *
     * Returns list of providers
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
     *
     * @OA\Get(
     *      path="/providers/{providerId}",
     *      operationId="selectByProviderId",
     *      tags={"Select Provider By ProviderId"},
     *      summary="Get provider information",
     *      description="Returns provider data",
     *      @OA\Parameter(
     *          name="providerId",
     *          description="Provider id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
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
