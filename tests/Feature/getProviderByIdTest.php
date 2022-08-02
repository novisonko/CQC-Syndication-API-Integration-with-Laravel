<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getProviderByIdTest extends TestCase
{
    /**
     *Test has success response
     *
     * @return void
     */
    public function testHasSuccessResponse()
    {
        $providerId= '1-10000227676';

        $response = $this->get('/api/providers/' . $providerId);

        $response->assertStatus(200);
    }

    /**
     *Test response has providerId
     *
     * @return void
     */
    public function testHasProviderId()
    {
        $providerId= '1-10000227676';

        $response = $this->get('/api/providers/' . $providerId);
       
        $res = json_decode($response->content(), true);

        if(!is_array($res)){
            $res= [];
        }

        $this->assertArrayHasKey('providerId', $res);
    }
}
