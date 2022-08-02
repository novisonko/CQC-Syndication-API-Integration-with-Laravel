<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class getProvidersTest extends TestCase
{
    /**
     * Test response is successful
     *
     * @return void
     */
    public function testHasSuccessResponse()
    {
        $providerId= '';

        $response = $this->get('/api/providers/');

        $response->assertStatus(200);
    }
}
