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
     * Show the response of photos
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
}
