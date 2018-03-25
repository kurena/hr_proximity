<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    /**
     * Prueba de ruta para login
     *
     * @return void
     */
    public function testLoginRoute()
    {
      $response = $this->get('/login');
      $response->assertStatus(200);
    }
}
