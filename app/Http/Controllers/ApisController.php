<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;

class ApisController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the response of animes
     *
     */
    public function animes() {

        $client = new Client([
            'base_uri' => 'https://api.jikan.moe',
        ]);

        $response = $client->request('GET', '/v3/genre/anime/1/1');

        $animes = json_decode($response->getBody()->getContents());

        return view('apisresponse.animes')->with('animes', $animes);
    }

        /**
     * Show the response of animes
     *
     */
    public function discounts() {

        $client = new Client([
            'base_uri' => 'http://ec2-54-167-6-108.compute-1.amazonaws.com',
        ]);

        $response = $client->request('GET', '/public/api/discounts');

        $discounts = json_decode($response->getBody()->getContents());

        return view('apisresponse.discounts')->with('discounts', $discounts);
    }
}
