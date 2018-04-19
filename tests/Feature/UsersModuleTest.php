<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersModuleTest extends TestCase
{
    /** @test */
    function loads_users_page()
    {
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('Franco')
            ->assertSee('German')
            ->assertSee('Yismeida');
    }

    /** @test */
    function loads_empty_users_page()
    {
        $this->get('/usuarios?empty')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    /** @test */
    function loads_users_details_page()
    {
        $this->get('/usuarios/5')
            ->assertStatus(200)
            ->assertSee('Mostrar un usuario')
            ->assertSee('Mostrando detalle del usuario: 5');
    }

    /** @test */
    function only_numeric_users_details_page()
    {
        $this->get('/usuarios/a')
            ->assertStatus(404);
    }

    /** @test */
    function loads_new_user_page()
    {
        $this->get('/usuarios/nuevo')
            ->assertStatus(200)
            ->assertSee('Crear nuevo usuario');
    }
}
