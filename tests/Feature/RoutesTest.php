<?php

namespace Tests\Feature;

use Tests\TestCase;

class RoutesTest extends TestCase
{
    /*
    *
    * @return void
    */
    public function testHome()
    {
       $response = $this->get('/')->assertStatus(302);
       $response->assertRedirect('/login');  
    }

    public function testLogin()
    {
       $response = $this->post('/login', [
        'email'     => 'carlitosthb@hotmail.com',
        'password'  => '12345678',
        ]);

       $response->assertRedirect('/');  
    }

    public function testCodes()
    {
       $response = $this->get('/code/list');
       $response->assertStatus(200);  
    }
}