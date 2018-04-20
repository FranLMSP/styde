<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersModuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function loads_users_page()
    {

        factory(User::class)->create([
            'name' => 'Franco'
        ]);
        factory(User::class)->create([
            'name' => 'German'
        ]);
        factory(User::class)->create([
            'name' => 'Yismeida'
        ]);

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
        $this->get('/usuarios')
            ->assertStatus(200)
            ->assertSee('Listado de usuarios')
            ->assertSee('No hay usuarios registrados');
    }

    /** @test */
    function display_user_name()
    {
        $user = factory(User::class)->create([
            'name' => 'Franco Colmenarez'
        ]);

        $this->get('/usuarios/'.$user->id)
            ->assertStatus(200)
            ->assertSee('Mostrar un usuario')
            ->assertSee('Franco Colmenarez');
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

    /** @test */
    function shows_404_error_if_user_doesnt_exist()
    {
        $this->get('/usuarios/999')
            ->assertStatus(404)
            ->assertSee('No encontrado');
    }

    /** @test */
    function it_creates_new_user()
    {

        $this->post('/usuarios',[
            'name' => 'Prueba',
            'email' => 'a@a.com',
            'password' => '123456'
        ])->assertRedirect('/usuarios');

        //This won't work
        /*

        $this->assertDatabaseHas('users', [
            'name' => 'Prueba',
            'email' => 'a@a.com',
            'password' => bcrypt('123456')
        ]);

        */

        $this->assertCredentials([
            'name' => 'Prueba',
            'email' => 'a@a.com',
            'password' => '123456'
        ]);
    }

    /** @test */
    function the_name_field_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'email' => 'b@b.com',
                'password' => '123456'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors([
                'name' => 'El campo nombre es obligatorio'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'email' => 'b@b.com'
        ]);
    }
}
