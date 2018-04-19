<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /** @test */
    function it_welcomes_users_with_nickname()
    {
    	$this->get('saludo/franco/fran')
    		->assertStatus(200)
    		->assertSee('Bienvenido Franco, tu apodo es fran');
    }

    /** @test */
    function it_welcomes_users_without_nickname()
    {
    	$this->get('saludo/Franco')
    		->assertStatus(200)
    		->assertSee('Bienvenido Franco');
    }
}
