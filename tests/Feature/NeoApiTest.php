<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NeoApiTest extends TestCase {

    use DatabaseTransactions;

    /**
     * Test index page.
     *
     * @return void
     */
    public function testIndex() {
        $response = $this->json('GET', '/');
        $response->assertStatus(200)->assertJson([
            'hello' => 'world'
        ]);
    }

    /**
     * Test neo page
     * 
     * @return void
     */
    public function testNeo() {
        $response = $this->json('GET', '/neo');
        $response->assertStatus(200)->assertJsonStructure([
            'number_of_asteroids',
            'saved_to_database'
        ]);
    }

    /**
     * Test neo hazardous page
     * 
     * @return void
     */
    public function testNeoHazardous() {
        $response = $this->json('GET', '/neo/hazardous');
        $response->assertStatus(200)->assertJsonStructure([
            [
                'name',
                'reference_id',
                'speed',
                'is_hazardous'
            ]
        ]);
    }

    /**
     * Test neo fastest page
     * 
     * @return void
     */
    public function testNeoFastest() {
        $response = $this->json('GET', '/neo/fastest');
        $response->assertStatus(200)->assertJsonStructure([
            'name',
            'reference_id',
            'speed',
            'is_hazardous'
        ]);
    }
    
    /**
     * Test neo best year
     * 
     * @return void
     */
    public function testNeoBestYear() {
        $response = $this->json('GET', '/neo/best-year');
        $response->assertStatus(200);
    }
    /**
     * Test neo best month
     * 
     * @return void
     */
    public function testNeoBestMonth() {
        $response = $this->json('GET', '/neo/best-month');
        $response->assertStatus(200);
    }

}
