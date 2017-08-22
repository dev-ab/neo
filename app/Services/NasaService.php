<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class NasaService {

    /**
     * Nasa API URI
     * 
     * @var string 
     */
    protected $api_uri = 'https://api.nasa.gov/neo/rest/v1';

    /**
     * The API KEY for the app account
     * 
     * @var string 
     */
    protected $key;

    /**
     * The Guzzle Http Client to make api requests 
     * 
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Contains the last requested feed data to perform other operations easily on it
     * 
     * @var array 
     */
    protected $current_feed;

    /**
     * Construct a new NasaService Instance
     * 
     * @param GuzzleHttp\Client $client
     * @param string $key
     */
    public function __construct(Client $client, $key) {
        $this->client = $client;
        $this->key = $key;
    }

    /**
     * Request the nasa astroids feed for a specifc period of time and return the result
     * 
     * @param string $end_date (yyy-mm-dd)
     * @param string $start_date (yyy-mm-dd)
     * @return array
     */
    public function feed($end_date, $start_date = null) {
        try {
            $res = $this->client->get($this->api_uri . '/feed', [
                'query' => [
                    'api_key' => $this->key,
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]
            ]);
        } catch (RequestException $e) {
            //error occured
            return ['error' => $e->getMessage()];
        }

        if ($res->getStatusCode() == 200) {
            $this->current_feed = json_decode($res->getBody(), true);
            return $this->current_feed;
        } else {
            return ['error' => 'Request returned an error'];
        }
    }

    /**
     * Save the current feed to the database and choose weather to empty the current data or not
     * 
     * @param boolean $emptyCurrent
     * @return void
     */
    public function saveToDatabase($emptyCurrent = true) {

        if ($emptyCurrent)
            \App\Neo::truncate();

        foreach ($this->current_feed['near_earth_objects'] as $date => $neos) {
            foreach ($neos as $neo) {
                \App\Neo::create([
                    'name' => $neo['name'],
                    'reference_id' => $neo['neo_reference_id'],
                    'speed' => $neo['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'],
                    'is_hazardous' => $neo['is_potentially_hazardous_asteroid'],
                    'date' => $date,
                ]);
            }
        }

        return;
    }

}
