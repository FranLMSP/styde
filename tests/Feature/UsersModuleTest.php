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
    function loads_edit_user_page()
    {
        $user = factory(User::class)->create();

        $this->get("/usuarios/{$user->id}/editar")
            ->assertStatus(200)
            ->assertViewIs('users.edit')
            ->assertSee('Editar usuario #'.$user->id)
            ->assertViewHas('user', function($viewUser) use($user){
                return $viewUser->id == $user->id;
            });
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
    function it_updates_existing_user()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();



        $this->put("/usuarios/{$user->id}",[
            'name' => 'Prueba',
            'email' => 'a@a.com',
            'password' => '123456'
        ])->assertRedirect("/usuarios/{$user->id}");

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
            ->assertSessionHasErrors(['name']);
        
        $this->assertDatabaseMissing('users', [
            'email' => 'b@b.com'
        ]);
    }

    /** @test */
    function the_email_field_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Test',
                'email' => '',
                'password' => '123456'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors([
                'email' => 'El campo email es obligatorio'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'name' => 'Test'
        ]);
    }

    /** @test */
    function the_email_field_must_be_valid()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Test',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors([
                'email' => 'El campo email no es válido'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'name' => 'Test'
        ]);
    }

    /** @test */
    function the_email_field_must_be_unique()
    {
        //$this->withoutExceptionHandling();

        factory(User::class)->create([
            'name' => 'Used',
            'email' => 'used@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Test',
                'email' => 'used@email.com',
                'password' => '123456'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors([
                'email' => 'El email ya está en uso'
            ]);
        
        //Only the user created with the factory must be counted
        //Not two or more
        $this->assertEquals(1, User::count());
    }

    /** @test */
    function the_password_field_is_required()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Test',
                'email' => 'c@c.com'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors([
                'password' => 'El campo password es obligatorio'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'email' => 'c@c.com'
        ]);
    }

    /** @test */
    function the_password_field_must_have_six_chars_min()
    {
        //$this->withoutExceptionHandling();

        $this->from('/usuarios/nuevo')
            ->post('/usuarios',[
                'name' => 'Test',
                'email' => 'c@c.com',
                'password' => '123'
            ])
            ->assertRedirect('/usuarios/nuevo')
            ->assertSessionHasErrors([
                'password' => 'La contraseña debe tener al menos 6 caracteres'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'email' => 'c@c.com'
        ]);
    }


    /** @test */
    function the_name_field_is_required_on_updating()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'email' => 'b@b.com',
                'password' => '123456'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors(['name']);
        
        $this->assertDatabaseMissing('users', [
            'email' => 'b@b.com'
        ]);
    }

    /** @test */
    function the_email_field_is_required_on_updating()
    {
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}",[
                'name' => 'Test',
                'email' => '',
                'password' => '123456'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'email' => 'El campo email es obligatorio'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'name' => 'Test'
        ]);
    }

    /** @test */
    function the_email_field_must_be_valid_on_updating()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Test',
                'email' => 'correo-no-valido',
                'password' => '123456'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'email' => 'El campo email no es válido'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'name' => 'Test'
        ]);
    }

    /** @test */
    function the_email_field_must_be_unique_on_updating()
    {
        //$this->withoutExceptionHandling();

        self::markTestIncomplete();
        return;

        factory(User::class)->create([
            'name' => 'Used',
            'email' => 'used@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Test',
                'email' => 'used@email.com',
                'password' => '123456'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'email' => 'El email ya está en uso'
            ]);
        
        //Only the user created with the factory must be counted
        //Not two or more
        $this->assertEquals(1, User::count());
    }

    /** @test */
    function the_password_field_is_required_on_updating()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Test',
                'email' => 'c@c.com'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'password' => 'El campo password es obligatorio'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'email' => 'c@c.com'
        ]);
    }

    /** @test */
    function the_password_field_must_have_six_chars_min_on_updating()
    {
        //$this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->from("/usuarios/{$user->id}/editar")
            ->put("/usuarios/{$user->id}", [
                'name' => 'Test',
                'email' => 'c@c.com',
                'password' => '123'
            ])
            ->assertRedirect("/usuarios/{$user->id}/editar")
            ->assertSessionHasErrors([
                'password' => 'La contraseña debe tener al menos 6 caracteres'
            ]);
        
        $this->assertDatabaseMissing('users', [
            'email' => 'c@c.com'
        ]);
    }

}
