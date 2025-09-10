<?php

namespace Tests\Unit\Socios;

use PHPUnit\Framework\TestCase;
use App\Models\Contacto;
use App\Models\User;

class SocioCheckTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_verificar_si_un_documento_esta_en_socio_contacto_y_user()
    {
        // Arrange: crear datos de prueba
        $socio = Socio::factory()->create(['documento' => '12345678']);
        $contacto = Contacto::factory()->create(['documento' => '12345678']);
        $user = User::factory()->create(['documento' => '12345678']);

        // Act: llamamos al método que aún vamos a crear
        $result = app('App\Services\SocioService')->checkByDocumento('12345678');

        // Assert: verificamos lo que esperamos
        $this->assertTrue($result['socio']);
        $this->assertTrue($result['contacto']);
        $this->assertTrue($result['user']);
    }

    /** @test */
    public function puede_tener_contacto_sin_user()
    {
        $socio = Socio::factory()->create(['documento' => '87654321']);
        $contacto = Contacto::factory()->create(['documento' => '87654321']);
        // no creamos user

        $result = app('App\Services\SocioService')->checkByDocumento('87654321');

        $this->assertTrue($result['socio']);
        $this->assertTrue($result['contacto']);
        $this->assertFalse($result['user']); // puede no existir
    }
}
