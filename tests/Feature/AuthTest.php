<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    // ==========================================
    // PRUEBAS DE LOGIN
    // ==========================================

    /** @test */
    public function la_pagina_de_login_carga_correctamente()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Iniciar Sesión');
    }

    /** @test */
    public function login_falla_con_campos_vacios()
    {
        $response = $this->post('/login', [
            'email'    => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function login_falla_con_email_invalido()
    {
        $response = $this->post('/login', [
            'email'    => 'esto-no-es-un-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function login_falla_con_credenciales_incorrectas()
    {
        User::factory()->create([
            'email'    => 'cliente@novaq.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'cliente@novaq.com',
            'password' => 'contraseña_incorrecta',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function login_exitoso_redirige_al_dashboard()
    {
        User::factory()->create([
            'email'    => 'cliente@novaq.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'cliente@novaq.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function usuario_autenticado_no_puede_ver_el_login()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/dashboard');
    }

    // ==========================================
    // PRUEBAS DE PROTECCIÓN DE RUTAS
    // ==========================================

    /** @test */
    public function usuario_no_autenticado_no_puede_ver_el_dashboard()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function usuario_autenticado_puede_ver_el_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    // ==========================================
    // PRUEBAS DE LOGOUT
    // ==========================================

    /** @test */
    public function logout_cierra_sesion_correctamente()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    // ==========================================
    // PRUEBAS DE RECUPERACIÓN DE CONTRASEÑA
    // ==========================================

    /** @test */
    public function la_pagina_de_recuperacion_carga_correctamente()
    {
        $response = $this->get('/recover');
        $response->assertStatus(200);
        $response->assertSee('Recuperar Contraseña');
    }

    /** @test */
    public function recuperacion_falla_con_email_no_registrado()
    {
        $response = $this->post('/recover', [
            'email' => 'noexiste@novaq.com',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function recuperacion_exitosa_con_email_registrado()
    {
        User::factory()->create([
            'email' => 'cliente@novaq.com',
        ]);

        $response = $this->post('/recover', [
            'email' => 'cliente@novaq.com',
        ]);

        $response->assertSessionHas('status');
    }
}